<?php

namespace App\Providers;

use App\Events\ItemApproved;
use App\Events\ItemRejected;
use App\Events\UserRegistered;
use App\Events\WithdrawalReceived;
use App\Listeners\NotifiyItemApproved;
use App\Listeners\NotifiyItemRejected;
use App\Listeners\NotifyWithdrawalReceived;
use App\Listeners\SendWelcomeEmail;
use Illuminate\Support\Facades\Event;
use Illuminate\Foundation\Support\Providers\EventServiceProvider as ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    /**
     * The event listener mappings for the application.
     *
     * @var array
     */
    protected $listen = [
        UserRegistered::class => [
            SendWelcomeEmail::class,
        ],
        WithdrawalReceived::class => [
            NotifyWithdrawalReceived::class,
        ],
        ItemApproved::class => [
            NotifiyItemApproved::class,
        ],
        ItemRejected::class => [
            NotifiyItemRejected::class,
        ]
    ];

    /**
     * Register any events for your application.
     *
     * @return void
     */
    public function boot()
    {
        parent::boot();

        //
    }
}
