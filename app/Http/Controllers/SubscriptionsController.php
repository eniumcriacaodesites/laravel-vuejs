<?php

namespace CodeBills\Http\Controllers;

use CodeBills\Criteria\FindSubscriptionByCanceledCriteria;
use CodeBills\Criteria\FindSubscriptionByExpiredCriteria;
use CodeBills\Criteria\FindSubscriptionByStatusCriteria;
use CodeBills\Iugu\SubscriptionManager;
use CodeBills\Repositories\SubscriptionRepository;

class SubscriptionsController extends Controller
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * @var SubscriptionManager
     */
    private $subscriptionManager;

    /**
     * MyFinancialController constructor.
     *
     * @param SubscriptionRepository $subscriptionRepository
     * @param SubscriptionManager $subscriptionManager
     */
    public function __construct(
        SubscriptionRepository $subscriptionRepository,
        SubscriptionManager $subscriptionManager
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->subscriptionManager = $subscriptionManager;
    }

    public function index()
    {
        $search = request()->get('search', '');
        $orderBy = request()->get('orderBy', 'id');
        $sortedBy = request()->get('sortedBy', 'asc');

        $expiresFrom = request()->get('expires_from', '');
        $expiresTo = request()->get('expires_to', '');
        $canceledFrom = request()->get('canceled_from', '');
        $canceledTo = request()->get('canceled_to', '');
        $status = request()->get('status', '');

        if (!in_array($orderBy, ['plan_id', 'code', 'user_id', 'expires_at', 'canceled_at', 'status'])) {
            $orderBy = 'plan_id';
            request()->offsetSet('orderBy', $orderBy);
        }

        $this->subscriptionRepository->pushCriteria(new FindSubscriptionByCanceledCriteria($canceledFrom, $canceledTo));
        $this->subscriptionRepository->pushCriteria(new FindSubscriptionByExpiredCriteria($expiresFrom, $expiresTo));
        $this->subscriptionRepository->pushCriteria(new FindSubscriptionByStatusCriteria($status));

        $subscriptions = $this->subscriptionRepository->paginate();

        return view('admin.subscriptions.index',
            compact('subscriptions', 'search', 'orderBy', 'sortedBy',
                'expiresFrom', 'expiresTo', 'canceledFrom', 'canceledTo', 'status'));
    }

    public function cancel($subscriptionId)
    {
        $this->subscriptionManager->cancel($subscriptionId);

        return redirect()->route('admin.subscriptions.index')->with('success', 'Assinatura cancelada com sucesso.');
    }
}
