<?php

namespace CodeBills\Repositories;

use Carbon\Carbon;
use Prettus\Repository\Contracts\RepositoryInterface;

/**
 * Interface StatementRepository
 *
 * @package namespace CodeBills\Repositories;
 */
interface StatementRepository extends RepositoryInterface
{
    public function getCashFlow(Carbon $dateStart, Carbon $dateEnd);

    public function getBalanceByMonth(Carbon $date);
}
