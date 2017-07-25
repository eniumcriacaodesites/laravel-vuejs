<?php

namespace CodeBills\Http\Controllers\Api;

use CodeBills\Criteria\FindBetweenCreatedAtBRCriteria;
use CodeBills\Criteria\FindByValueBRCriteria;
use CodeBills\Http\Controllers\Controller;
use CodeBills\Repositories\StatementRepository;
use Illuminate\Http\Request;

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

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
    {
        $searchParam = config('repository.criteria.params.search');
        $search = $request->get($searchParam);
        $this->statementRepository
            ->pushCriteria(new FindBetweenCreatedAtBRCriteria($search))
            ->pushCriteria(new FindByValueBRCriteria($search));
        $statements = $this->statementRepository->paginate();

        return response()->json($statements, 200);
    }
}
