<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobTag extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'id',
        'name',
        'sort_order',
    ];

    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'job_post_tag');
    }
}
