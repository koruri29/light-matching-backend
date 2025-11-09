<?php

namespace App\Repositories\JobPost;

use Illuminate\Support\Collection;

interface JobPostRepositoryInterface
{
    public function create(array $data);
    public function getJobCountsByDate(): Collection;
    public function getPaginatedJobs(): Collection;
}
