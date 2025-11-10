<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Events\MigrationsStarted;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Vite;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->configureModels();
        $this->configureUrl();
        $this->configureVite();
        $this->configureMigration();
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }

    /**
     * Configure the application's models.
     */
    public function configureModels(): void
    {
        Model::preventLazyLoading(! app()->isProduction());
        Model::shouldBeStrict();
    }

    /**
     * Configure the application's URL.
     */
    public function configureUrl(): void
    {
        if (app()->isProduction() || env('FORCE_HTTPS') === true) {
            URL::forceHttps();
        }
    }

    /**
     * Configure the application's Vite.
     */
    public function configureVite(): void
    {
        Vite::usePrefetchStrategy('aggressive');
    }

    /**
     * Configure the application's migrations.
     */
    public function configureMigration(): void
    {
        Event::listen(MigrationsStarted::class, function () {
            Schema::disableForeignKeyConstraints();
        });
    }
}
