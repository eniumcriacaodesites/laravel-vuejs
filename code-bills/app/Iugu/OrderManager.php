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
     * @var IuguInvoiceClient
     */
    private $iuguInvoiceClient;

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
     * @param IuguInvoiceClient $iuguInvoiceClient
     * @param SubscriptionRepository $subscriptionRepository
     * @param OrderRepository $orderRepository
     */
    public function __construct(
        IuguSubscriptionClient $iuguSubscriptionClient,
        IuguInvoiceClient $iuguInvoiceClient,
        SubscriptionRepository $subscriptionRepository,
        OrderRepository $orderRepository
    ) {
        $this->iuguSubscriptionClient = $iuguSubscriptionClient;
        $this->iuguInvoiceClient = $iuguInvoiceClient;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->orderRepository = $orderRepository;
    }

    public function create($data)
    {
        $iuguSubscription = $this->iuguSubscriptionClient->find($data['subscription_id']);
        $subscription = $this->subscriptionRepository->findByField('code', $iuguSubscription->id)->first();

        if ($subscription) {
            $invoice = $iuguSubscription->recent_invoices[0];
            $total = $this->getValue($invoice->total);

            return $this->orderRepository->create([
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

    public function paid(array $data)
    {
        $invoice = $this->iuguInvoiceClient->find($data['id']);
        $order = $this->orderRepository->findByField('code', $invoice->id)->first();

        if ($order && $order->status != Order::STATUS_PAID) {
            $this->orderRepository->update([
                'status' => Order::STATUS_PAID,
                'payment_date' => (new Carbon())->format('Y-m-d H:i:s'),
            ], $order->id);
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
