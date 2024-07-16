<?php

namespace App\Jobs\SendMail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class RegisterSuccessfully implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(protected $nameEmail , protected $nameUser,protected $password)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $nameEmail = $this->nameEmail;
        $nameUser = $this->nameUser;
        $password = $this->password;
        try {
            Mail::send('email.register', compact('nameUser','nameEmail','password'), function ($email) use($nameEmail,$nameUser) {
                $email->subject('Registered Successfully');
                $email->to($nameEmail, $nameUser);
            });
        } catch (\Exception $e) {
            throw $e;
        }
    }
}
