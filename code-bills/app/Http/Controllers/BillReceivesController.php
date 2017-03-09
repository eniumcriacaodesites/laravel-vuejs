<?php

namespace CodeBills\Http\Controllers;

use CodeBills\Http\Requests\BillReceiveRequest;
use CodeBills\Repositories\BillReceiveRepository;

class BillReceivesController extends Controller
{
    /**
     * @var BillReceiveRepository
     */
    private $billReceiveRepository;

    /**
     * BanksController constructor.
     *
     * @param BillReceiveRepository $billReceiveRepository
     */
    public function __construct(BillReceiveRepository $billReceiveRepository)
    {
        $this->billReceiveRepository = $billReceiveRepository;
        $this->billReceiveRepository->skipPresenter(true);
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

        $bills = $this->billReceiveRepository->paginate();

        return view('admin.bill-receives.index', compact('bills', 'search', 'orderBy', 'sortedBy'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.bill-receives.form');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BillReceiveRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(BillReceiveRequest $request)
    {
        $data = $request->all();

        $data['done'] = !isset($data['done']) ? false : true;

        $this->billReceiveRepository->create($data);

        return redirect()->route('admin.bill-receives.index');
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $bank = $this->billReceiveRepository->find($id);

        return view('admin.bill-receives.form', compact('bank'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BillReceiveRequest $request
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function update(BillReceiveRequest $request, $id)
    {
        $data = $request->all();

        $data['done'] = !isset($data['done']) ? false : true;

        $this->billReceiveRepository->update($data, $id);

        return redirect()->route('admin.bill-receives.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->billReceiveRepository->delete($id);

        return redirect()->route('admin.bill-receives.index');
    }
}
