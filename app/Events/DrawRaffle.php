<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DrawRaffle implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $prize;
    public function __construct($prize)
    {
        $this->prize = $prize;
        \Log::info('Draw Raffle event fired', [
            'prize' => $prize,
            'channel' => $this->broadcastOn(),
            'event' => $this->broadcastAs(),
        ]);
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
        return [
            new PrivateChannel('draw-raffle'),
        ];
    }

    public function broadcastAs()
    {
        return 'draw-raffle';
    }
}
