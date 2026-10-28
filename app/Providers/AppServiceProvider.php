<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Schema;
use App\Repositories\Interfaces\TicketRepositoryInterface;
use App\Repositories\Implementations\TicketRepositoryImplementation;
use App\Services\Interfaces\TicketInterfaceService;
use App\Services\Implementations\TicketImplementationService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
          // Liaison du Repository
        $this->app->bind(
            TicketRepositoryInterface::class,
            TicketRepositoryImplementation::class
        );

        // Liaison du Service
        $this->app->bind(
            TicketInterfaceService::class,
            TicketImplementationService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
     
       Schema::defaultStringLength(191);
    }
}
