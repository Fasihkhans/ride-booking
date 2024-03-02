<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class DriverAvailability implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $driverId;
    public $latitude;
    public $longitude;
    public $data;
    /**
     * Create a new event instance.
     */
    public function __construct(int $driverId,$latitude,$longitude)
    {
        $this->driverId = $driverId;
        $this->longitude = $longitude;
        $this->latitude = $latitude;
        $this->data = ['driverId'=>$this->driverId,'latitude'=>$this->latitude,'longitude'=> $this->longitude];
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new PrivateChannel('driver.'.$this->driverId),
        ];
    }

    public function broadcastWith(): array
    {
        return ['data' => $this->data];
    }
}
