<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPostDate extends Model
{
    protected $fillable = [
        'job_post_id',
        'work_date',
    ];

    public function jobPost()
    {
        return $this->belongsToMany(JobPost::class);
    }
}
