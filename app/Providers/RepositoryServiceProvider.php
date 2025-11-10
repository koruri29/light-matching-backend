<?php

namespace App\Providers;

use App\Repositories\JobPost\JobPostRepository;
use App\Repositories\JobPost\JobPostRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(JobPostRepositoryInterface::class, JobPostRepository::class);
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
