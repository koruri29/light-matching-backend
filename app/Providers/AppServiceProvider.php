<?php

namespace App\Providers;

use App\Repositories\Auth\RegisterUserRepository;
use App\Repositories\Auth\RegisterUserRepositoryInterface;
use App\Repositories\JobPost\JobPostRepository;
use App\Repositories\JobPost\JobPostRepositoryInterface;
use App\Repositories\JobPostDate\JobPostDateRepository;
use App\Repositories\JobPostDate\JobPostDateRepositoryInterface;
use App\Repositories\JobPostTags\JobPostTagsRepository;
use App\Repositories\JobPostTags\JobPostTagsRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(JobPostRepositoryInterface::class, JobPostRepository::class);
        $this->app->bind(JobPostTagsRepositoryInterface::class, JobPostTagsRepository::class);
        $this->app->bind(JobPostDateRepositoryInterface::class, JobPostDateRepository::class);
        $this->app->bind(RegisterUserRepositoryInterface::class, RegisterUserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
