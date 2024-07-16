<?php

namespace App\Jobs\SendMail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class CancelBooking implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */

    protected $nameEmail;
    protected $date;
    protected $time;
    protected $nameBadmintonCourt;
    protected $addressBadmintonCourt;
    public function __construct($user, $date, $time, $nameBadmintonCourt, $addressBadmintonCourt)
    {
        $this->nameEmail = $user->email;
        $this->date = $date;
        $this->time = $time;
        $this->nameBadmintonCourt = $nameBadmintonCourt;
        $this->addressBadmintonCourt = $addressBadmintonCourt;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $nameEmail = $this->nameEmail;
        $date = $this->date;
        $time = $this->time;
        $nameBadmintonCourt = $this->nameBadmintonCourt;
        $addressBadmintonCourt = $this->addressBadmintonCourt;
        try {
            Mail::send('email.cancel-booking',compact('date','time','nameBadmintonCourt','addressBadmintonCourt'), function ($email) use($nameEmail) {
                $email->subject('Booking Canceled Notification');
                $email->to($nameEmail);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
        }
    }
}
