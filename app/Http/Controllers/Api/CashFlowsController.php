<?php

namespace CodeBills\Http\Controllers\Api;

use Carbon\Carbon;
use CodeBills\Http\Controllers\Controller;
use CodeBills\Repositories\StatementRepository;

class CashFlowsController extends Controller
{
    /**
     * @var StatementRepository
     */
    private $statementRepository;

    /**
     * CashFlowsController constructor.
     *
     * @param StatementRepository $statementRepository
     */
    public function __construct(StatementRepository $statementRepository)
    {
        $this->statementRepository = $statementRepository;
    }

    public function index()
    {
        $dateStart = new Carbon('2017-02-01');
        $dateEnd = $dateStart->copy()->addMonths(10);

        return $this->statementRepository->getCashFlow($dateStart, $dateEnd);
    }

    public function byPeriod()
    {
        $dateStart = new Carbon();
        $dateEnd = $dateStart->copy()->addDays(30);

        return $this->statementRepository->getCashFlowByPeriod($dateStart, $dateEnd);
    }
}
