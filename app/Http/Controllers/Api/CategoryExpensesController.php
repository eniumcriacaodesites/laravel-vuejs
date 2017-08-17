<?php

namespace CodeBills\Http\Controllers\Api;

use CodeBills\Criteria\FindRootCategoriesCriteria;
use CodeBills\Criteria\WithDepthCategoriesCriteria;
use CodeBills\Http\Controllers\Controller;
use CodeBills\Http\Controllers\Response;
use CodeBills\Http\Requests\CategoryExpenseRequest;
use CodeBills\Repositories\CategoryExpenseRepository;

class CategoryExpensesController extends Controller
{
    /**
     * @var CategoryExpenseRepository
     */
    private $repository;

    /**
     * BillPaysController constructor.
     *
     * @param CategoryExpenseRepository $repository
     */
    public function __construct(CategoryExpenseRepository $repository)
    {
        $this->repository = $repository;
        $this->repository->pushCriteria(new WithDepthCategoriesCriteria());
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $this->repository->pushCriteria(new FindRootCategoriesCriteria());
        $categories = $this->repository->all();

        return response()->json($categories, 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  CategoryExpenseRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(CategoryExpenseRequest $request)
    {
        $category = $this->repository->skipPresenter()->create($request->all());
        $this->repository->skipPresenter(false);
        $category = $this->repository->find($category->id);

        return response()->json($category, 201);
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
        $category = $this->repository->find($id);

        return response()->json($category, 200);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param CategoryExpenseRequest $request
     * @param  string $id
     * @return Response
     */
    public function update(CategoryExpenseRequest $request, $id)
    {
        $category = $this->repository->skipPresenter()->update($request->all(), $id);
        $this->repository->skipPresenter(false);
        $category = $this->repository->find($category->id);

        return response()->json($category, 200);
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
