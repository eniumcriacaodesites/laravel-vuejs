<?php

namespace CodeBills\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Queue\SerializesModels;

class BillStoredEvent
{
    use InteractsWithSockets, SerializesModels;

    private $model;

    private $modelOld;

    /**
     * Create a new event instance.
     *
     * @param $model
     * @param $modelOld
     */
    public function __construct($model, $modelOld = null)
    {
        $this->model = $model;
        $this->modelOld = $modelOld;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }

    /**
     * @return mixed
     */
    public function getModel()
    {
        return $this->model;
    }

    /**
     * @return mixed
     */
    public function getModelOld()
    {
        return $this->modelOld;
    }
}
