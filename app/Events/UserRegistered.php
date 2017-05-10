<?php

namespace EverestBill\Events;

use EverestBill\Models\User;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class UserRegistered
{
    use InteractsWithSockets, SerializesModels;

    /**
     * User Id
     * @var integer
     */
    public $userId;

    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct($userId)
    {
        $this->userId = $userId;
    }
}
