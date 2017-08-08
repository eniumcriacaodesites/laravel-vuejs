<?php

namespace CodeBills\Http\Middleware;

use Carbon\Carbon;
use Closure;
use CodeBills\Criteria\FindSubscriptionByUserClientCriteria;
use CodeBills\Models\Subscription;
use CodeBills\Repositories\SubscriptionRepository;
use Illuminate\Support\Facades\Auth;

class CheckSubscription
{
    /**
     * @var SubscriptionRepository
     */
    private $subscriptionRepository;

    /**
     * CheckSubscription constructor.
     *
     * @param SubscriptionRepository $subscriptionRepository
     */
    public function __construct(SubscriptionRepository $subscriptionRepository)
    {
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @param string $beforeOrAfter
     * @return mixed
     */
    public function handle($request, Closure $next, $beforeOrAfter = 'before')
    {
        if ($beforeOrAfter == 'before') {
            $responseExpired = $this->responseSubscriptionExpired();

            if ($responseExpired) {
                return $responseExpired;
            }

            return $next($request);
        } else {
            $response = $next($request);
            $responseExpired = $this->responseSubscriptionExpired();

            return !$responseExpired ? $response : $responseExpired;
        }
    }

    protected function responseSubscriptionExpired()
    {
        $subscription = $this->getSubscription();

        if ($subscription) {
            $result = $this->isExpired($subscription);

            if ($result) {
                return response()->json([
                    'error' => 'subscription_expired',
                    'message' => 'Assinatura Expirada.',
                ], 403);
            }
        } else {
            return response()->json([
                'error' => 'subscription_not_found',
                'message' => 'Cliente sem assinatura contrada.',
            ], 400);
        }

        return false;
    }

    protected function getSubscription()
    {
        $client = Auth::guard('api')->user()->client;

        $subscription = $this->subscriptionRepository
            ->getByCriteria(new FindSubscriptionByUserClientCriteria($client->id))
            ->first();

        return $subscription;
    }

    protected function isExpired($subscription)
    {
        if (!$subscription->expires_at ||
            $subscription->status == Subscription::STATUS_INATIVE ||
            $subscription->canceled_at != null
        ) {
            return true;
        }

        $expiresAt = new Carbon($subscription->expires_at);

        return $expiresAt->lt(new Carbon()) ? true : false;
    }
}
