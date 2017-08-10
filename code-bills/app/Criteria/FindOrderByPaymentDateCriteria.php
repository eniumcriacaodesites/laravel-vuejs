<?php

namespace CodeBills\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindOrderByPaymentDateCriteria
 * @package namespace CodeBills\Criteria;
 */
class FindOrderByPaymentDateCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $paymentFrom;

    /**
     * @var
     */
    private $paymentTo;

    /**
     * FindOrderByPaymentDateCriteria constructor.
     *
     * @param $paymentFrom
     * @param $paymentTo
     */
    public function __construct($paymentFrom, $paymentTo)
    {
        $this->paymentFrom = $paymentFrom;
        $this->paymentTo = $paymentTo;
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
        if ($this->paymentFrom) {
            $model->where('payment_date', '>=', dateBrToEn($this->paymentFrom));
        }

        if ($this->paymentTo) {
            $model->where('payment_date', '<=', dateBrToEn($this->paymentTo));
        }

        return $model;
    }
}
