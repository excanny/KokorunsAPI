<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Portfolio extends Model
{
    use HasFactory;

    protected $fillable = [
        'image',
        'user_id',
        'portfolio_id',
    ];

    protected $hidden = ['id', 'updated_at'];
}
