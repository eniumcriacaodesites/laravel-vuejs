<?php

namespace CodeBills\Http\Controllers\Site;

use CodeBills\Criteria\FindByUserCriteria;
use CodeBills\Http\Controllers\Controller;
use CodeBills\Iugu\SubscriptionManager;
use CodeBills\Repositories\SubscriptionRepository;

class MyFinancialController extends Controller
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
        $this->subscriptionRepository->pushCriteria(new FindByUserCriteria());
        $subscriptions = $this->subscriptionRepository->paginate();

        return view('site.subscriptions.my_financial', compact('subscriptions'));
    }

    public function cancel($subscriptionId)
    {
        $this->subscriptionManager->cancel($subscriptionId);

        return redirect()->route('site.my_financial.index')->with('success', 'Assinatura cancelada com sucesso.');
    }
}
