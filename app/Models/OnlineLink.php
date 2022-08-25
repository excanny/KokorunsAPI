<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OnlineLink extends Model
{
    use HasFactory;

    protected $fillable = [

        'user_id',
        'online_link_id',
        'link_title',
        'link_address',
    ];

    protected $hidden = ['id', 'updated_at'];
}
