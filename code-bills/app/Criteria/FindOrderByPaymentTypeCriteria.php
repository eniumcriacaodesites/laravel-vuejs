<?php

namespace CodeBills\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindOrderByPaymentTypeCriteria
 *
 * @package namespace CodeBills\Criteria;
 */
class FindOrderByPaymentTypeCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $paymentType;

    /**
     * FindOrderByPaymentTypeCriteria constructor.
     *
     * @param $paymentType
     */
    public function __construct($paymentType)
    {
        $this->paymentType = $paymentType;
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
        if ($this->paymentType) {
            return $model->where('payment_type', $this->paymentType);
        }

        return $model;
    }
}
