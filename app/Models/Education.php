<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    use HasFactory;

    protected $table = 'educations';

    protected $fillable = [
        'user_id',
        'education_id',
        'start',
        'end',
        'course',
        'school',
        'class_of_degree',
        'roles',
        'skills',
        'is_current'
    ];

    protected $hidden = ['id', 'updated_at'];
}
