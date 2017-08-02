<?php

namespace CodeBills\Http\Controllers\Site;

use CodeBills\Http\Controllers\Controller;
use CodeBills\Repositories\PlanRepository;

class SubscriptionsController extends Controller
{
    /**
     * @var PlanRepository
     */
    private $planRepository;

    /**
     * SubscriptionsController constructor.
     *
     * @param PlanRepository $planRepository
     */
    public function __construct(PlanRepository $planRepository)
    {
        $this->planRepository = $planRepository;
    }

    public function create()
    {
        $plan = $this->planRepository->all()->first();

        return view('site.subscriptions.create', compact('plan'));
    }

    public function store()
    {
        dd(request());
    }
}
