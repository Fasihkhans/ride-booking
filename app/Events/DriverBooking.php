<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverBooking implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $driverId;
    public $booking;

    /**
     * Create a new event instance.
     */
    public function __construct(int $driverId,$booking)
    {
        $this->driverId = $driverId;
        $this->booking = $booking;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('driver-booking.'.$this->driverId),
        ];
    }


     /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return ['booking' => $this->booking];
    }
}
