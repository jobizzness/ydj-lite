<?php

namespace App\Providers;

use App\Modules\User\Data\Repository\DbUserRepository;
use App\Modules\User\Data\Repository\UserRepositoryInterface;
use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        App::bind(UserRepositoryInterface::class, DbUserRepository::class);
    }
}
