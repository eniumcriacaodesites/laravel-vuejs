<?php

namespace CodeBills\Iugu;

use CodeBills\Models\Client;
use CodeBills\Models\Plan;
use CodeBills\Models\User;

class IuguSubscriptionManager
{
    /**
     * @var IuguCustomerClient
     */
    private $iuguCustomerClient;

    /**
     * @var IuguPaymentMethodClient
     */
    private $iuguPaymentMethodClient;

    /**
     * @var IuguSubscriptionClient
     */
    private $iuguSubscriptionClient;

    /**
     * IuguSubscriptionManager constructor.
     *
     * @param IuguCustomerClient $iuguCustomerClient
     * @param IuguPaymentMethodClient $iuguPaymentMethodClient
     * @param IuguSubscriptionClient $iuguSubscriptionClient
     */
    public function __construct(
        IuguCustomerClient $iuguCustomerClient,
        IuguPaymentMethodClient $iuguPaymentMethodClient,
        IuguSubscriptionClient $iuguSubscriptionClient
    ) {
        $this->iuguCustomerClient = $iuguCustomerClient;
        $this->iuguPaymentMethodClient = $iuguPaymentMethodClient;
        $this->iuguSubscriptionClient = $iuguSubscriptionClient;
    }

    public function create(User $user, Plan $plan, $data)
    {
        $client = $user->client;
        $customer = $this->makeCustomer($client);
        $customerId = $customer == null ? $client->code : $customer['id'];

        $this->makePaymentMethod($customerId, $data['payment_type'], $data['token_payment']);

        return $this->iuguSubscriptionClient->create([
            'user_id' => $user->id,
            'plan_id' => $plan->id,
            'plan_identifier' => $plan->code,
            'customer_id' => $customerId,
            'payment_type' => $data['payment_type'],
        ]);
    }

    protected function makeCustomer(Client $client)
    {
        if ($client->code == null) {
            $this->iuguCustomerClient->create($client->toArray());
        }

        return null;
    }

    protected function makePaymentMethod($customerId, $paymentType, $token)
    {
        if ($paymentType == 'credit_card') {
            return $this->iuguPaymentMethodClient->create([
                'customer_id' => $customerId,
                'token' => $token,
            ]);
        }
    }
}
