<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    use HasFactory;

    protected $fillable = [
        'team_id',
        'team_name',
        'team_description',
        'team_privacy',
        'team_purpose',
        'team_members',
        'team_icon',
        'admin',
    ];

    protected $hidden = ['id', 'updated_at'];
}
