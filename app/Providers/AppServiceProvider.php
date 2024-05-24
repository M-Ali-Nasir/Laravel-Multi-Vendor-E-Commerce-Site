<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Providers\FacebookServiceProvider;


use Illuminate\Http\Request;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Custom Facebook provider registration
        $this->app->register(FacebookServiceProvider::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
