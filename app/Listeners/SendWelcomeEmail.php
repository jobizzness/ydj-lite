<?php

namespace App\Listeners;

use App\Mail\Welcome;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class SendWelcomeEmail
{
    public $user;

    /**
     * Create the event listener.
     *
     * @param $user
     */
    public function __construct()
    {

    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle($event)
    {
        Mail::to( $event->user->email )->send( new Welcome( $event->user ) );
    }
}
