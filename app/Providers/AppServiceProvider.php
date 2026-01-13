<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\ImageCompressorService;
use App\Services\PhotoProcessingService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Register our custom services
        $this->app->singleton(ImageCompressorService::class, function ($app) {
            return new ImageCompressorService();
        });
        
        $this->app->singleton(PhotoProcessingService::class, function ($app) {
            return new PhotoProcessingService(
                $app->make(ImageCompressorService::class)
            );
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}