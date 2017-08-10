<?php

namespace CodeBills\Http\Controllers;

use CodeBills\Criteria\FindOrderByDueDateCriteria;
use CodeBills\Criteria\FindOrderByPaymentDateCriteria;
use CodeBills\Criteria\FindOrderByPaymentTypeCriteria;
use CodeBills\Criteria\FindOrderByStatusCriteria;
use CodeBills\Repositories\OrderRepository;

class OrdersController extends Controller
{
    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * OrdersController constructor.
     *
     * @param OrderRepository $orderRepository
     */
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }

    public function index()
    {
        $search = request()->get('search', '');
        $orderBy = request()->get('orderBy', 'code');
        $sortedBy = request()->get('sortedBy', 'asc');

        $dueFrom = request()->get('due_from', '');
        $dueTo = request()->get('due_to', '');
        $paymentFrom = request()->get('payment_from', '');
        $paymentTo = request()->get('payment_to', '');
        $paymentType = request()->get('payment_type', '');
        $status = request()->get('status', '');

        if (!in_array($orderBy, ['code', 'value', 'date_due', 'payment_date', 'payment_type', 'status'])) {
            $orderBy = 'code';
            request()->offsetSet('orderBy', $orderBy);
        }

        $this->orderRepository->pushCriteria(new FindOrderByDueDateCriteria($dueFrom, $dueTo));
        $this->orderRepository->pushCriteria(new FindOrderByPaymentDateCriteria($paymentFrom, $paymentTo));
        $this->orderRepository->pushCriteria(new FindOrderByPaymentTypeCriteria($paymentType));
        $this->orderRepository->pushCriteria(new FindOrderByStatusCriteria($status));

        $orders = $this->orderRepository->paginate();

        return view('admin.orders.index',
            compact('orders', 'search', 'orderBy', 'sortedBy',
                'dueFrom', 'dueTo', 'paymentFrom', 'paymentTo', 'paymentType', 'status'));
    }
}
