<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserJob extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'job_id',
        'job_description', 
        'salary',
        'location', 
        'employment_type', 
        'languages',
        'skills', 
        'user_id', 
    ];

    protected $hidden = ['id', 'updated_at'];
}
