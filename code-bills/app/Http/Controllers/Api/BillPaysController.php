<?php

namespace CodeBills\Http\Controllers\Api;

use CodeBills\Http\Controllers\Controller;
use CodeBills\Http\Controllers\Response;
use CodeBills\Http\Requests\BillPayRequest;
use CodeBills\Repositories\BillPayRepository;

class BillPaysController extends Controller
{
    /**
     * @var BillPayRepository
     */
    private $repository;

    /**
     * BillPaysController constructor.
     *
     * @param BillPayRepository $repository
     */
    public function __construct(BillPayRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $billPays = $this->repository->paginate();

        return response()->json($billPays, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BillPayRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BillPayRequest $request)
    {
        $billPay = $this->repository->create($request->all());

        return response()->json($billPay, 201);
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
        $billPay = $this->repository->find($id);

        return response()->json($billPay, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BillPayRequest $request
     * @param  string $id
     * @return Response
     */
    public function update(BillPayRequest $request, $id)
    {
        $billPay = $this->repository->update($request->all(), $id);

        return response()->json($billPay, 200);
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
