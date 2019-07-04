<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Schema::defaultStringLength(191);
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        // $this->app['request']->server->set('HTTPS', $this->app->environment() != 'local'); // После этого, вспомогательные функции Laravel такие, как route(), action(), asset() и другие будут автоматически генерировать адреса с HTTPS
    }
}
