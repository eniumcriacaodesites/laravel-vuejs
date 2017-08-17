<?php

namespace CodeBills\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindSubscriptionByExpiredCriteria
 *
 * @package namespace CodeBills\Criteria;
 */
class FindSubscriptionByExpiredCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $expiresFrom;

    /**
     * @var
     */
    private $expiresTo;

    /**
     * FindSubscriptionByExpiredCriteria constructor.
     *
     * @param $expiresFrom
     * @param $expiresTo
     */
    public function __construct($expiresFrom, $expiresTo)
    {
        $this->expiresFrom = $expiresFrom;
        $this->expiresTo = $expiresTo;
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
        if ($this->expiresFrom) {
            $model->where('expires_at', '>=', dateBrToEn($this->expiresFrom));
        }

        if ($this->expiresTo) {
            $model->where('expires_at', '<=', dateBrToEn($this->expiresTo));
        }

        return $model;
    }
}
