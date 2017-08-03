<?php

namespace CodeBills\Events;

use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Queue\SerializesModels;

class IuguSubscriptionCreatedEvent
{
    use InteractsWithSockets, SerializesModels;

    private $iuguSubscription;

    private $userId;

    private $planId;

    /**
     * Create a new event instance.
     *
     * @param $iuguSubscription
     * @param $userId
     * @param $planId
     */
    public function __construct($iuguSubscription, $userId, $planId)
    {
        $this->iuguSubscription = $iuguSubscription;
        $this->userId = $userId;
        $this->planId = $planId;
    }

    /**
     * @return mixed
     */
    public function getIuguSubscription()
    {
        return $this->iuguSubscription;
    }

    /**
     * @return mixed
     */
    public function getUserId()
    {
        return $this->userId;
    }

    /**
     * @return mixed
     */
    public function getPlanId()
    {
        return $this->planId;
    }
}
