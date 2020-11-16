<?php

namespace App\Providers;

use App\Custom\Classes\Holidays;
use Illuminate\Support\ServiceProvider;

class HolidaysServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('holidays', function () {
            return new Holidays();
        });
    }
}
