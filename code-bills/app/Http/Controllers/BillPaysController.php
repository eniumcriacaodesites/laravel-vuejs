<?php

namespace CodeBills\Http\Controllers;

use CodeBills\Http\Requests\BillPayRequest;
use CodeBills\Repositories\BillPayRepository;

class BillPaysController extends Controller
{
    /**
     * @var BillPayRepository
     */
    private $billPayRepository;

    /**
     * BanksController constructor.
     *
     * @param BillPayRepository $billPayRepository
     */
    public function __construct(BillPayRepository $billPayRepository)
    {
        $this->billPayRepository = $billPayRepository;
        $this->billPayRepository->skipPresenter(true);
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

        if (!in_array($orderBy, ['id', 'date_due', 'name', 'value', 'done'])) {
            $orderBy = 'id';
            request()->offsetSet('orderBy', $orderBy);
        }

        $bills = $this->billPayRepository->paginate();

        return view('admin.bill-pays.index', compact('bills', 'search', 'orderBy', 'sortedBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bill-pays.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BillPayRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillPayRequest $request)
    {
        $data = $request->all();

        $data['done'] = !isset($data['done']) ? false : true;

        $this->billPayRepository->create($data);

        return redirect()->route('admin.bill-pays.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = $this->billPayRepository->find($id);

        return view('admin.bill-pays.form', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BillPayRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillPayRequest $request, $id)
    {
        $data = $request->all();

        $data['done'] = !isset($data['done']) ? false : true;

        $this->billPayRepository->update($data, $id);

        return redirect()->route('admin.bill-pays.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->billPayRepository->delete($id);

        return redirect()->route('admin.bill-pays.index');
    }
}
