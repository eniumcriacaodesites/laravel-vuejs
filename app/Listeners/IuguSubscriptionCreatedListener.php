<?php

namespace CodeBills\Listeners;

use CodeBills\Events\IuguSubscriptionCreatedEvent;
use CodeBills\Models\Subscription;
use CodeBills\Repositories\SubscriptionRepository;

class IuguSubscriptionCreatedListener
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * Create the event listener.
     *
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Handle the event.
     *
     * @param  IuguSubscriptionCreatedEvent $event
     * @return void
     */
    public function handle(IuguSubscriptionCreatedEvent $event)
    {
        $iuguSubscription = $event->getIuguSubscription();
        $invoice = $iuguSubscription->recent_invoices[0];

        $this->subscriptionRepository->create([
            'code' => $iuguSubscription->id,
            'user_id' => $event->getUserId(),
            'plan_id' => $event->getPlanId(),
            'expires_at' => $iuguSubscription->expires_at,
            'status' => $invoice->status == 'paid' ? Subscription::STATUS_ATIVE : Subscription::STATUS_INATIVE,
        ]);
    }
}
