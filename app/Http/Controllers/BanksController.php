<?php

namespace CodeBills\Http\Controllers;

use CodeBills\Http\Requests\BankRequest;
use CodeBills\Repositories\BankRepository;

class BanksController extends Controller
{
    /**
     * @var BankRepository
     */
    private $bankRepository;

    /**
     * BanksController constructor.
     *
     * @param BankRepository $bankRepository
     */
    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
        $this->bankRepository->skipPresenter(true);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $search = request()->get('search', '');
        $orderBy = request()->get('orderBy', 'id');
        $sortedBy = request()->get('sortedBy', 'asc');

        if (!in_array($orderBy, ['id', 'name'])) {
            $orderBy = 'id';
            request()->offsetSet('orderBy', $orderBy);
        }

        $banks = $this->bankRepository->paginate();

        return view('admin.banks.index', compact('banks', 'search', 'orderBy', 'sortedBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.banks.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BankRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BankRequest $request)
    {
        $this->bankRepository->create($request->all());

        return redirect()->route('admin.banks.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = $this->bankRepository->find($id);

        return view('admin.banks.form', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BankRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, $id)
    {
        $this->bankRepository->update($request->all(), $id);

        return redirect()->route('admin.banks.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->bankRepository->delete($id);

        return redirect()->route('admin.banks.index');
    }
}
