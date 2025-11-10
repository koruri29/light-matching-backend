<?php

namespace App\UseCases\Jobs;

use App\Repositories\JobPost\JobPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GetJobPostsAction
{
    private JobPostRepository $repository;

    public function __construct(JobPostRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(int $perPage)
    {
        return $this->repository->getPaginatedJobs($perPage);
    }
}
