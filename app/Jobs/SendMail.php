<?php

namespace App\Jobs;

use App\Mail\AccountVerificationMail;
use Exception;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMail implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;
    private $recipient;
    private $mailTemplate;

    /**
     * Create a new job instance.
     */
    public function __construct($recipient, Mailable $mailTemplate)
    {
        $this->recipient = $recipient;
        $this->mailTemplate = $mailTemplate;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            Mail::to($this->recipient)->send($this->mailTemplate);
           error_log('email sents');
        } catch (Exception $exception) {
            error_log(env('APP_DEBUG') ? $exception->getMessage() . $exception->getLine() . $exception->getFile() . $exception : 'Please contact developer');
        }
    }
}