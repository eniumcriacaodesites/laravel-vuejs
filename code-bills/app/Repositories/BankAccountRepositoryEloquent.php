<?php

namespace CodeBills\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use CodeBills\Repositories\BankAccountRepository;
use CodeBills\Models\BankAccount;
use CodeBills\Validators\BankAccountValidator;

/**
 * Class BankAccountRepositoryEloquent
 * @package namespace CodeBills\Repositories;
 */
class BankAccountRepositoryEloquent extends BaseRepository implements BankAccountRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return BankAccount::class;
    }

    

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
}
