<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class RealtimeEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    private $actionId;
    private $actionData;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($actionId, $actionData)
    {
        $this->actionId = $actionId;
        $this->actionData = $actionData;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new Channel('realtime-notify-channel');
    }

    /**
     * Get the data to broadcast.
     *
     * @author Author
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'actionId' => $this->actionId,
            'actionData' => $this->actionData,
        ];
    }
}
