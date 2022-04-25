<?php

namespace App\Events\Common;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdateCachesDataEvent
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $model = null;
    public $cache_name = null;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($model = null, $cache_name = null)
    {
        $this->model = $model;
        $this->cache_name = $cache_name;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return \Illuminate\Broadcasting\Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
