<?php

namespace CodeBills\Events;

use CodeBills\Models\BankAccount;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class BankAccountBalanceUpdatedEvent implements ShouldBroadcast
{
    /**
     * @var BankAccount
     */
    public $bankAccount;

    /**
     * Create a new event instance.
     *
     * @param BankAccount $bankAccount
     */
    public function __construct(BankAccount $bankAccount)
    {
        $this->bankAccount = $bankAccount;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel("client.{$this->bankAccount->client_id}");
    }
}
