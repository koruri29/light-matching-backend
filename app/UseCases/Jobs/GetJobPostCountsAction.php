<?php

namespace App\UseCases\Jobs;

use App\Repositories\JobPost\JobPostRepository;
use Illuminate\Support\Collection;

class GetJobPostCountsAction
{
    private JobPostRepository $repository;

    public function __construct(JobPostRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(): Collection
    {
        return $this->repository->getJobCountsByDate();
    }
}
