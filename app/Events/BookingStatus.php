<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class BookingStatus implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $bookingId;
    public $status;
    public $data;
    /**
     * Create a new event instance.
     */
    public function __construct($bookingId,$status)
    {
        $this->bookingId = $bookingId;
        $this->status =  $status;
        $this->data = ['bookingId'=>$this->bookingId,"status"=>$this->status];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
            return [
                new PrivateChannel('booking.'.$this->bookingId)
            ];
            // new Channel('booking.'.$this->bookingId);

    }

    public function broadcastWith(): array
    {
        return ['data' => $this->data];
    }
    // public function broadcastAs()
    // {
    //     return 'booking';
    // }
}
