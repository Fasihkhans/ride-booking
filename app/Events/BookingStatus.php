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
    public $booking;
    /**
     * Create a new event instance.
     */
    public function __construct($bookingId,$status,$booking = null)
    {
        $this->bookingId = $bookingId;
        $this->status =  $status;
        $this->booking = $booking;
        $this->data = ['bookingId'=>$this->bookingId,"status"=>$this->status,"booking"=>$this->booking];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn()
    {
            return [
                new Channel('booking.'.$this->bookingId)
            ];
    }

    public function broadcastWith(): array
    {
        return ['data' => $this->data];
    }
}
