<?php

namespace App\Models;

use Illuminate\Container\Attributes\Tag;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'event_name',
        'prefecture',
        'location',
        'description',
        'payment',
        'contact_method',
        'is_public',
        'is_closed',
        'deadline',
        'number_of_position',
    ];

    public function jobTags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function jobPostDates()
    {
        return $this->hasMany(JobPostDate::class);
    }

    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
}
