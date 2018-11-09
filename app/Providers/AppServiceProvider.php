<?php

namespace App\Providers;

use App\Modules\Media\Repository\DbMediaRepository;
use App\Modules\Product\Repository\DbProductRepository;
use App\Modules\Product\Repository\ProductRepositoryInterface;
use App\Modules\Repository\MediaRepositoryInterface;
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
        App::bind(MediaRepositoryInterface::class, DbMediaRepository::class);
        App::bind(ProductRepositoryInterface::class, DbProductRepository::class);
    }
}
