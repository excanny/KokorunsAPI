<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Experience extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'experience_id',
        'start',
        'end',
        'company_name',
        'position',
        'roles',
        'is_current'
    ];

    protected $hidden = ['id', 'updated_at'];
}
