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

    protected $hidden = ['pivot', 'created_at', 'updated_at'];


    public function jobPosts()
    {
        return $this->belongsToMany(JobPost::class, 'job_post_tag');
    }
}
