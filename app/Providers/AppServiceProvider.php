<?php

namespace App\Providers;

use App\Youtube\YoutubeService;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        schema::defaultStringLength(191);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->singleton('App\Youtube\YoutubeService', function () {
            return new YoutubeService(env('YOUTUBE_API_KEY'));
        });
    }
}
