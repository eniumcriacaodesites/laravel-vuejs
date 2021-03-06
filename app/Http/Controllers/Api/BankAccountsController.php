<?php

namespace CodeBills\Http\Controllers\Api;

use CodeBills\Http\Controllers\Controller;
use CodeBills\Http\Controllers\Response;
use CodeBills\Http\Requests\BankAccountRequest;
use CodeBills\Http\Requests\BankAccountUpdateRequest;
use CodeBills\Repositories\BankAccountRepository;
use Illuminate\Http\Request;

class BankAccountsController extends Controller
{
    /**
     * @var BankAccountRepository
     */
    private $repository;

    /**
     * BankAccountsController constructor.
     *
     * @param BankAccountRepository $repository
     */
    public function __construct(BankAccountRepository $repository)
    {
        $this->repository = $repository;
    }

    public function lists()
    {
        return $this->repository->skipPresenter()->all(['id', 'name', 'account']);
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $limit = (int) $request->get('limit', null);
        $limit = $limit > 0 ? $limit : null;

        $bankAccounts = $this->repository->paginate($limit);

        return response()->json($bankAccounts, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BankAccountRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BankAccountRequest $request)
    {
        $bankAccount = $this->repository->create($request->all());

        return response()->json($bankAccount, 201);
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $bankAccount = $this->repository->find($id);

        return response()->json($bankAccount, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BankAccountRequest $request
     * @param  string $id
     * @return Response
     */
    public function update(BankAccountRequest $request, $id)
    {
        $bankAccount = $this->repository->update($request->all(), $id);

        return response()->json($bankAccount, 200);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->repository->delete($id);

        return response()->json([], 204);
    }
}
