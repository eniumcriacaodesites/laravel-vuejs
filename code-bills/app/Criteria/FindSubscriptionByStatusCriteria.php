<?php

namespace CodeBills\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindSubscriptionByStatusCriteria
 *
 * @package namespace CodeBills\Criteria;
 */
class FindSubscriptionByStatusCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $status;

    /**
     * FindSubscriptionByStatusCriteria constructor.
     *
     * @param $status
     */
    public function __construct($status)
    {
        $this->status = $status;
    }

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
        if ($this->status) {
            $model->where('status', $this->status);
        }

        return $model;
    }
}
