<?php

namespace App\Repositories\JobPost;

use App\Models\JobPost;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class JobPostRepository implements JobPostRepositoryInterface
{
    public function create (array $data)
    {
        return JobPost::Create($data);
    }

    public function getJobCountsByDate(): Collection
    {
        return DB::table('job_post_dates')
            ->select('work_date', DB::raw('count(*) as total'))
            ->groupBy('work_date')
            ->orderBy('work_date', 'desc')
            ->get();
    }
}
