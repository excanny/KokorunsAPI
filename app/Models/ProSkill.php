<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProSkill extends Model
{
    use HasFactory;

    protected $fillable = [
        'pro_skill',
        'user_id',
        'pro_skill_id',
    ];

    protected $hidden = ['id', 'updated_at'];
}
