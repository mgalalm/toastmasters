<?php

namespace App\Providers;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\UrlGenerator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(UrlGenerator $urlGenerator): void
    {
        if ($this->app->environment('production')) {
            $urlGenerator->forceScheme('https');
        }
        JsonResource::withoutWrapping();
        Model::preventLazyLoading();
    }
}
