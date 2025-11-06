<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class JobPostTag extends Pivot
{
    protected $table = 'job_post_tag';

    protected $fillable = ['job_post_id', 'tag'];
}
