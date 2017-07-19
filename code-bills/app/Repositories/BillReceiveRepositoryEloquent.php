<?php

namespace CodeBills\Repositories;

use CodeBills\Models\BillReceive;
use CodeBills\Presenters\BillReceivePresenter;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BillReceiveRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class BillReceiveRepositoryEloquent extends BaseRepository implements BillReceiveRepository
{
    use BillRepositoryTrait;

    protected $fieldSearchable = [
        'name' => 'like',
    ];

    public function create(array $attributes)
    {
        $model = parent::create($attributes);
        $this->repeatBill($attributes);

        return $model;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BillReceive::class;
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
        return BillReceivePresenter::class;
    }
}
