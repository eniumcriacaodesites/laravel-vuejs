<?php

namespace CodeBills\Criteria;

use Prettus\Repository\Contracts\CriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Class FindOrderByDueDateCriteria
 *
 * @package namespace CodeBills\Criteria;
 */
class FindOrderByDueDateCriteria implements CriteriaInterface
{
    /**
     * @var
     */
    private $dueFrom;

    /**
     * @var
     */
    private $dueTo;

    /**
     * FindOrderByDueDateCriteria constructor.
     *
     * @param $dueFrom
     * @param $dueTo
     */
    public function __construct($dueFrom, $dueTo)
    {
        $this->dueFrom = $dueFrom;
        $this->dueTo = $dueTo;
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
        if ($this->dueFrom) {
            $model->where('date_due', '>=', dateBrToEn($this->dueFrom));
        }

        if ($this->dueTo) {
            $model->where('date_due', '<=', dateBrToEn($this->dueTo));
        }

        return $model;
    }
}
