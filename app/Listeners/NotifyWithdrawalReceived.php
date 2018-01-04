<?php

namespace App\Listeners;

use App\Mail\WithdrawalReceived;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifyWithdrawalReceived
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to( $event->withdrawal->user->email )->send( new WithdrawalReceived($event->withdrawal) );
    }
}
