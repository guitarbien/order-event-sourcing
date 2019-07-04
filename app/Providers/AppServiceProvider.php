<?php

namespace App\Providers;

use App\Observers\StoredEventObserver;
use Illuminate\Support\ServiceProvider;
use Spatie\EventProjector\Models\StoredEvent;

/**
 * Class AppServiceProvider
 * @package App\Providers
 */
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        if ($this->app->isLocal()) {
            $this->app->register(TelescopeServiceProvider::class);
        }
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        StoredEvent::observe(StoredEventObserver::class);
    }
}
