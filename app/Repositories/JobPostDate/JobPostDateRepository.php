<?php

namespace App\Repositories\JobPostDate;

use App\Models\JobPostDate;
use App\Repositories\JobPostDate\JobPostDateRepositoryInterface;

class JobPostDateRepository implements JobPostDateRepositoryInterface
{
    public function create (array $data)
    {
        return JobPostDate::Create($data);
    }
}
