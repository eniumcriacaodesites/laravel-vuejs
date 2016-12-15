<?php

namespace CodeBills\Repositories;

use CodeBills\Events\BankStoredEvent;
use CodeBills\Models\Bank;
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
    public function create(array $attributes)
    {
        $logo = $attributes['logo'];
        $attributes['logo'] = 'no_image.png';
        $model = parent::create($attributes);

        event(new BankStoredEvent($model, $logo));

        return $model;
    }

    public function update(array $attributes, $id)
    {
        $logo = null;

        if (isset($attributes['logo']) && $attributes['logo'] instanceof UploadedFile) {
            $logo = $attributes['logo'];
            unset($attributes['logo']);
        }

        $model = parent::update($attributes, $id);

        event(new BankStoredEvent($model, $logo));

        return $model;
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
}
