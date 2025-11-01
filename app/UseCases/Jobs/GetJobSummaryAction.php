<?php

namespace App\UseCases\Jobs;

use App\Repositories\JobPost\JobPostRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class GetJobSummaryAction
{
    private JobPostRepository $repository;

    public function __construct(JobPostRepository $repository) {
        $this->repository = $repository;
    }

    public function __invoke(Request $request)
    {
        return [
            'counts' => $this->getJobCountsByDate(),
            'jobs' => $this->getPaginatedJobs($request)
        ];
    }

    private function getJobCountsByDate(): Collection
    {
        return $this->repository->getJobCountsByDate();
    }

    private function getPaginatedJobs(Request $request)
    {
        return [];
    }
}
