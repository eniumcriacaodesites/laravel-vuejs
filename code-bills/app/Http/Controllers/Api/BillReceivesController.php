<?php

namespace CodeBills\Http\Controllers\Api;

use CodeBills\Http\Controllers\Controller;
use CodeBills\Http\Controllers\Response;
use CodeBills\Http\Requests\BillReceiveRequest;
use CodeBills\Repositories\BillReceiveRepository;

class BillReceivesController extends Controller
{
    /**
     * @var BillReceiveRepository
     */
    private $repository;

    /**
     * BillReceivesController constructor.
     *
     * @param BillReceiveRepository $repository
     */
    public function __construct(BillReceiveRepository $repository)
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
        $billReceives = $this->repository->paginate();

        return response()->json($billReceives, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  BillReceiveRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BillReceiveRequest $request)
    {
        $billReceive = $this->repository->create($request->all());

        return response()->json($billReceive, 201);
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
        $billReceive = $this->repository->find($id);

        return response()->json($billReceive, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BillReceiveRequest $request
     * @param  string $id
     * @return Response
     */
    public function update(BillReceiveRequest $request, $id)
    {
        $billReceive = $this->repository->update($request->all(), $id);

        return response()->json($billReceive, 200);
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
