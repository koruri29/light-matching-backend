<?php

namespace App\Repositories\JobPostTags;

use App\Models\JobPostTag;

class JobPostTagsRepository implements JobPostTagsRepositoryInterface
{
    public function create (array $data) {
        return JobPostTag::Create($data);
    }
}
