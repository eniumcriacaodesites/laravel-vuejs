<?php

namespace CodeBills\Criteria;

use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindByUserCriteria
 *
 * @package namespace CodeBills\Criteria;
 */
class FindByUserCriteria implements CriteriaInterface
{
    /**
     * Apply criteria in query repository
     *
     * @param                     $model
     * @param RepositoryInterface $repository
     *
     * @return mixed
     */
    public function apply($model, RepositoryInterface $repository)
    {
        if (Auth::user()->role === 'admin') {
            return $model;
        }

        return $model->where('user_id', Auth::user()->id);
    }
}
