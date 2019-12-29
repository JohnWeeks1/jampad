<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use App\Mail\Users\Registration;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;

class SendMailJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * User instance.
     *
     * @var $user
     */
    protected $user;

    /**
     * SendMailJob constructor.
     *
     * @param $user
     *
     * return void
     */
    public function __construct($user)
    {
        $this->user = $user;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        Mail::to($this->user->email)->send(new Registration($this->user));
    }
}
