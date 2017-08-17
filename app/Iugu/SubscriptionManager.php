<?php

namespace CodeBills\Iugu;

use Carbon\Carbon;
use CodeBills\Criteria\FindByUserCriteria;
use CodeBills\Models\Subscription;
use CodeBills\Repositories\SubscriptionRepository;

class SubscriptionManager
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
     * SubscriptionManager constructor.
     *
     * @param IuguSubscriptionClient $iuguSubscriptionClient
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(
        IuguSubscriptionClient $iuguSubscriptionClient,
        SubscriptionRepository $subscriptionRepository
    ) {
        $this->iuguSubscriptionClient = $iuguSubscriptionClient;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    public function renew($data)
    {
        $iuguSubscription = $this->iuguSubscriptionClient->find($data['id']);
        $subscription = $this->subscriptionRepository->findByField('code', $iuguSubscription->id)->first();
        $result = $subscription;

        if ($subscription && $subscription->expires_at != $iuguSubscription->expires_at) {
            $result = $this->subscriptionRepository->update([
                'expires_at' => $iuguSubscription->expires_at,
                'status' => Subscription::STATUS_ATIVE,
            ], $subscription->id);
        }

        return $result;
    }

    public function cancel($subscriptionId)
    {
        $this->subscriptionRepository->pushCriteria(new FindByUserCriteria());
        $subscription = $this->subscriptionRepository->find($subscriptionId);
        $this->iuguSubscriptionClient->suspend($subscription->code);

        $this->subscriptionRepository->update([
            'status' => Subscription::STATUS_INATIVE,
            'canceled_at' => (new Carbon())->format('Y-m-d'),
        ], $subscription->id);
    }
}
