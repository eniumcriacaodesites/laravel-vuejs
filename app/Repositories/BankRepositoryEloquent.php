<?php

namespace CodeBills\Repositories;

use CodeBills\Events\BankStoredEvent;
use CodeBills\Models\Bank;
use CodeBills\Presenters\BankPresenter;
use Illuminate\Support\Facades\Storage;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * Class BankRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class BankRepositoryEloquent extends BaseRepository implements BankRepository
{
    protected $fieldSearchable = [
        'name' => 'like',
    ];

    public function create(array $attributes)
    {
        $logo = $attributes['logo'];
        $attributes['logo'] = env('BANK_LOGO_DEFAULT');
        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = parent::create($attributes);

        event(new BankStoredEvent($model, $logo));

        $this->skipPresenter = $skipPresenter;

        return $this->parserResult($model);
    }

    public function update(array $attributes, $id)
    {
        $logo = null;

        if (isset($attributes['logo']) && $attributes['logo'] instanceof UploadedFile) {
            $logo = $attributes['logo'];
            unset($attributes['logo']);
        }

        $skipPresenter = $this->skipPresenter;
        $this->skipPresenter(true);

        $model = parent::update($attributes, $id);

        event(new BankStoredEvent($model, $logo));

        $this->skipPresenter = $skipPresenter;

        return $this->parserResult($model);
    }

    public function delete($id)
    {
        $bank = $this->find($id);

        Storage::disk('public')->delete(Bank::logosDir() . '/' . $bank->logo);

        return parent::delete($id);
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Bank::class;
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
        return BankPresenter::class;
    }
}
