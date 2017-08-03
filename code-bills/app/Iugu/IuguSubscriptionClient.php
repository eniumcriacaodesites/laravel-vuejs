<?php

namespace CodeBills\Iugu;

use CodeBills\Events\IuguSubscriptionCreatedEvent;
use CodeBills\Iugu\Exceptions\IuguSubscriptionException;

class IuguSubscriptionClient
{
    public function find($id)
    {
        $result = \Iugu_Subscription::fetch($id);

        if (isset($result['errors'])) {
            throw new IuguSubscriptionException($result['errors']);
        }

        return $result;
    }

    public function create(array $attributes)
    {
        $paymentType = $attributes['payment_type'];
        $attributes['payable_with'] = $paymentType;
        $attributes['only_on_change_success'] = $paymentType == 'credit_card' ? true : false;

        $result = \Iugu_Subscription::create(array_only($attributes, [
            'customer_id',
            'payable_with',
            'only_on_change_success',
            'plan_identifier',
        ]));

        if (isset($result['errors'])) {
            throw new IuguSubscriptionException($result['errors']);
        }

        event(new IuguSubscriptionCreatedEvent($result, $attributes['user_id'], $attributes['plan_id']));

        return $result;
    }
}
