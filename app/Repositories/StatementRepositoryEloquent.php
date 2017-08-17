<?php

namespace CodeBills\Repositories;

use CodeBills\Models\BillPay;
use CodeBills\Models\BillReceive;
use CodeBills\Models\Statement;
use CodeBills\Presenters\StatementSerializerPresenter;
use CodeBills\Serializer\StatementSerializer;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class StatementRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class StatementRepositoryEloquent extends BaseRepository implements StatementRepository
{
    use CashFlowRepositoryTrait;

    protected $fieldSearchable = [
        'bankAccount.name' => 'like',
    ];

    public function paginate($limit = null, $columns = ['*'], $method = "paginate")
    {
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter();
        $collection = parent::paginate($limit, $columns, $method);
        $this->skipPresenter($skipPresenter);

        return $this->parserResult(new StatementSerializer($collection, $this->formatStatementsData()));
    }

    protected function getCountAndTotalByBill($billType)
    {
        $this->resetModel();
        $this->resetCriteria();

        $collection = $this->model
            ->selectRaw("COUNT(id) AS count, SUM(value) AS total")
            ->where("statementable_type", "=", $billType)->get();

        $result = $collection->first();

        return [
            'count' => (float) $result->count,
            'total' => (float) $result->total,
        ];
    }

    protected function formatStatementsData()
    {
        $resultRevenue = $this->getCountAndTotalByBill(BillReceive::class);
        $resultExpense = $this->getCountAndTotalByBill(BillPay::class);

        return [
            'count' => $resultExpense['count'] + $resultExpense['count'],
            'revenues' => ['total' => $resultRevenue['total']],
            'expenses' => ['total' => $resultExpense['total']],
        ];
    }

    public function create(array $attributes)
    {
        $statementable = $attributes['statementable'];

        return $statementable->statements()->create(array_except($attributes, 'statementable'));
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Statement::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function presenter()
    {
        return StatementSerializerPresenter::class;
    }
}
