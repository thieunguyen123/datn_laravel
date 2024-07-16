<?php

namespace App\Jobs\SendMail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class ForgotPassword implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $nameEmail;
    protected $token;
    public function __construct($nameEmail, $token)
    {
        $this->nameEmail = $nameEmail;
        $this->token = $token;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $nameEmail = $this->nameEmail;
        $token = $this->token;
        try {
            Mail::send('email.forgot-password', compact('nameEmail','token'), function ($email) use($nameEmail) {
                $email->subject('Link to ResetPassword');
                $email->to($nameEmail);
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
