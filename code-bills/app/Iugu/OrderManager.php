<?php

namespace CodeBills\Iugu;

use Carbon\Carbon;
use CodeBills\Models\Order;
use CodeBills\Repositories\OrderRepository;
use CodeBills\Repositories\SubscriptionRepository;

class OrderManager
{
    /**
     * @var IuguSubscriptionClient
     */
    private $iuguSubscriptionClient;

    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * @var OrderRepository
     */
    private $orderRepository;

    /**
     * OrderManager constructor.
     *
     * @param IuguSubscriptionClient $iuguSubscriptionClient
     * @param SubscriptionRepository $subscriptionRepository
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        IuguSubscriptionClient $iuguSubscriptionClient,
        SubscriptionRepository $subscriptionRepository,
        OrderRepository $orderRepository
    ) {
        $this->iuguSubscriptionClient = $iuguSubscriptionClient;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->orderRepository = $orderRepository;
    }

    public function create($data)
    {
        $iuguSubscription = $this->iuguSubscriptionClient->find($data['subscription_id']);
        $subscription = $this->subscriptionRepository->findByField('code', $iuguSubscription->id);

        if ($subscription) {
            $invoice = $iuguSubscription->recent_invoices[0];
            $total = $this->getValue($invoice->total);

            $this->orderRepository->create([
                'date_due' => $invoice->due_date,
                'payment_date' => $invoice->status == 'paid' ? (new Carbon())->format('Y-m-d H:i:s') : null,
                'subscription_id' => $subscription->id,
                'payment_url' => $invoice->secure_url,
                'code' => $invoice->id,
                'status' => $invoice->status == 'paid' ? Order::STATUS_PAID : Order::STATUS_PENDING,
                'value' => $total,
            ]);
        }
    }

    protected function getValue($value)
    {
        $value = str_replace(' ', '', $value);
        $curr = 'R$';
        $numberFormatter = new \NumberFormatter('pt-BR', \NumberFormatter::CURRENCY);

        return $numberFormatter->parseCurrency($value, $curr);
    }
}
