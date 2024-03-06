<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class SendFcmNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $deviceToken;
    protected $title;
    protected $body;
    protected $data;

    public function __construct($deviceToken, $title, $body, $data = null)
    {
        $this->deviceToken = $deviceToken;
        $this->title = $title;
        $this->body = $body;
        $this->data = $data;
    }

    public function handle()
    {
        $serverKey = env('FCM_SERVER_KEY');

        $fcmMsg = [
            'title' => $this->title,
            'body' => $this->body,
            'data' => $this->data
        ];

        $fcmFields = [
            'to' => $this->deviceToken,
            'priority' => 'high',
            'data' => $this->data,
            'notification' => $fcmMsg,
        ];

        $response = Http::withHeaders([
            'Authorization' => 'key=' .$serverKey,
            'Content-Type' => 'application/json',
        ])->post('https://fcm.googleapis.com/fcm/send', $fcmFields);

        Log::channel('fcm')->info($response->body());
    }
}
