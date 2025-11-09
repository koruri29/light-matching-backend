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

    /** 仕事数カウントを配列風(日付がキー、件数が値）にして返す */
    public function getJobCountsByDate(): Collection
    {
        return DB::table('job_post_dates')
            ->select('work_date', DB::raw('count(*) as total'))
            ->groupBy('work_date')
            ->orderBy('work_date', 'desc')
            ->pluck('total', 'work_date');
    }

    public function getPaginatedJobs($perPage = 20): Collection
    {
        return JobPost::with(['jobTags', 'jobPostDates'])
                    ->withMax('jobPostDates', 'work_date') // 各求人に紐づく最大日付を取る
                    ->orderBy('job_post_dates_max_work_date', 'desc') // その最大日付でソート
                    ->paginate($perPage);
    }
}
