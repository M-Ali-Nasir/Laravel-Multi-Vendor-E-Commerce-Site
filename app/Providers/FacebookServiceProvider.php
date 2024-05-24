<?php

namespace App\Providers;

use Facebook\Facebook;
use Illuminate\Support\ServiceProvider;

class FacebookServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        $this->app->singleton(Facebook::class, function($app){
            $config = config('services.facebook');
            return new Facebook([
                'app_app' => $config['client_id'],
                'app_secret' => $config['client_secret'],
                'default_graph_version' => 'v3.3'
            ]);
        });
    }
}
