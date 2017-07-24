<?php

namespace CodeBills\Http\Controllers\Api;

use CodeBills\Http\Controllers\Controller;
use CodeBills\Repositories\StatementRepository;

class StatementsController extends Controller
{
    /**
     * @var StatementRepository
     */
    private $statementRepository;

    /**
     * StatementsController constructor.
     *
     * @param StatementRepository $statementRepository
     */
    public function __construct(StatementRepository $statementRepository)
    {
        $this->statementRepository = $statementRepository;
    }

    public function index()
    {
        $statements = $this->statementRepository->paginate();

        return response()->json($statements, 200);
    }
}
