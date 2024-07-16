<?php

namespace App\Jobs\SendMail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CreateBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $nameEmail;
    public function __construct($owner)
    {
        $this->nameEmail = $owner->email;
    }
    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $nameEmail = $this->nameEmail;
        try {
            Mail::send('email.booking',[], function ($email) use($nameEmail) {
                $email->subject('Booking Confirmation');
                $email->to($nameEmail);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
        }
    }
}
