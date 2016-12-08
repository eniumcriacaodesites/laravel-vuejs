<?php

namespace CodeBills\Repositories;

use CodeBills\Models\Bank;
use CodeBills\Validators\BankValidator;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Class BankRepositoryEloquent
 *
 * @package namespace CodeBills\Repositories;
 */
class BankRepositoryEloquent extends BaseRepository implements BankRepository
{
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
