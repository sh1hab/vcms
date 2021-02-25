<?php

namespace Shihab\Zoom;

use Illuminate\Support\ServiceProvider;

class ZoomServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadMigrationsFrom(__DIR__.'/database/migrations');
        $this->publishes([
            __DIR__.'database/migrations.php' => config_path('database/migrations'),
        ]);
    }

}
