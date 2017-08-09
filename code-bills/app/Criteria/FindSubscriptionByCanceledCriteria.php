<?php

namespace CodeBills\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindSubscriptionByCanceledCriteria
 *
 * @package namespace CodeBills\Criteria;
 */
class FindSubscriptionByCanceledCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $canceledFrom;

    /**
     * @var
     */
    private $canceledTo;

    /**
     * FindSubscriptionByCanceledCriteria constructor.
     *
     * @param $canceledFrom
     * @param $canceledTo
     */
    public function __construct($canceledFrom, $canceledTo)
    {
        $this->canceledFrom = $canceledFrom;
        $this->canceledTo = $canceledTo;
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
        if ($this->canceledFrom) {
            $model->where('canceled_at', '>=', dateBrToEn($this->canceledFrom));
        }

        if ($this->canceledTo) {
            $model->where('canceled_at', '<=', dateBrToEn($this->canceledTo));
        }

        return $model;
    }
}
