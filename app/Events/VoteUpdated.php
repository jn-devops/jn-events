<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class VoteUpdated implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $votes;
    public $poll_id;
    public function __construct($votes, $poll_id)
    {
        $this->votes = $votes;
        $this->poll_id = $poll_id;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('poll-updates');
    }

    public function broadcastAs()
    {
        return 'vote.updated';
    }
}
