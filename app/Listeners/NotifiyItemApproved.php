<?php

namespace App\Listeners;

use App\Mail\ItemApproved;
use App\Mail\ItemRejected;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Mail;

class NotifiyItemApproved
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
        Mail::to( $event->product->owner->email )->send( new ItemApproved( $event->product ) );
    }
}
