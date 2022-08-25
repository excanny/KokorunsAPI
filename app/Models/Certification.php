<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certification extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'certification_id',
        'start',
        'end',
        'school',
        'course',
        'class_of_degree',
        'is_current'
    
    ];

    protected $hidden = ['id', 'updated_at'];
}
