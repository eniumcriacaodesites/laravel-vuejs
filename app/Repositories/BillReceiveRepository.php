<?php

namespace CodeBills\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryCriteriaInterface;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface BillReceiveRepository
 *
 * @package namespace CodeBills\Repositories;
 */
interface BillReceiveRepository extends RepositoryInterface, RepositoryCriteriaInterface
{
    public function getTotalFromPeriod(Carbon $dateStart, Carbon $dateEnd);
}
