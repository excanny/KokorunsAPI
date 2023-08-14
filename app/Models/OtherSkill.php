<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OtherSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'other_skill',
        'user_id',
        'other_skill_id',
    ];

    protected $hidden = ['id', 'updated_at'];
}
