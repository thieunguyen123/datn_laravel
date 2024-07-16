<?php

namespace App\Jobs\SendMail;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class AcceptBadmintonCourt implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    protected $nameCourt;
    protected $addressCourt;
    protected $nameEmail;
    public function __construct($court)
    {
        $this->nameCourt = $court->name;
        $this->addressCourt = $court->address;
        $this->nameEmail = User::find($court->court_owner_id)->email;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $addressCourt = $this->addressCourt;
        $nameCourt = $this->nameCourt;
        $nameEmail = $this->nameEmail;
        try {
            Mail::send('email.accept-court',compact('nameCourt','addressCourt'), function ($email) use($nameEmail) {
                $email->subject('Notification: Court Approved');
                $email->to($nameEmail);
            });
        } catch (\Exception $e) {
            \Illuminate\Support\Facades\Log::error($e);
        }
    }
}
