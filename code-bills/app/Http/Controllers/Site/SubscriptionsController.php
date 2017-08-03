<?php

namespace CodeBills\Http\Controllers\Site;

use CodeBills\Http\Controllers\Controller;
use CodeBills\Http\Requests\SubscriptionCreateRequest;
use CodeBills\Iugu\Exceptions\AbstractIuguException;
use CodeBills\Iugu\Exceptions\IuguCustomerException;
use CodeBills\Iugu\Exceptions\IuguPaymentMethodException;
use CodeBills\Iugu\Exceptions\IuguSubscriptionException;
use CodeBills\Iugu\IuguSubscriptionManager;
use CodeBills\Repositories\PlanRepository;

class SubscriptionsController extends Controller
{
    /**
     * @var PlanRepository
     */
    private $planRepository;

    /**
     * @var IuguSubscriptionManager
     */
    private $iuguSubscriptionManager;

    /**
     * SubscriptionsController constructor.
     *
     * @param PlanRepository $planRepository
     * @param IuguSubscriptionManager $iuguSubscriptionManager
     */
    public function __construct(PlanRepository $planRepository, IuguSubscriptionManager $iuguSubscriptionManager)
    {
        $this->planRepository = $planRepository;
        $this->iuguSubscriptionManager = $iuguSubscriptionManager;
    }

    public function create()
    {
        $plan = $this->planRepository->all()->first();

        return view('site.subscriptions.create', compact('plan'));
    }

    public function store(SubscriptionCreateRequest $request)
    {
        $plan = $this->planRepository->all()->first();

        try {
            $this->iuguSubscriptionManager->create(\Auth::user(), $plan, $request->all());
        } catch (AbstractIuguException $e) {
            return redirect()->route('site.subscriptions.create')->with('error', $this->getMessageException($e));
        }

        return redirect()->route('site.subscriptions.successfully');
    }

    public function successfully()
    {
        return view('site.subscriptions.successfully');
    }

    protected function getMessageException($exception)
    {
        if ($exception instanceof IuguCustomerException) {
            return 'Erro ao processar cliente. Contacte o atendimento para mais detalhes.';
        } elseif ($exception instanceof IuguPaymentMethodException) {
            return 'Erro ao salvar método de pagmaneto. Contacte o atendimento para mais detalhes.';
        } elseif ($exception instanceof IuguSubscriptionException) {
            return 'Erro ao processar assinatura. Contacte o atendimento para mais detalhes.';
        }
    }
}
