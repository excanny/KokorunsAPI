<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolEvent extends Model
{
    use HasFactory;
    protected $fillable = [
        'from', 'to', 'title', 'invitees', 'author', 'description', 'event_id', 'event_type' ,
        'event_industry', 'event_address', 'event_state', 'event_lga', 'event_price1', 'event_price2', 
        'event_image1', 'event_logo', 'school_id', 'event_link', 
    ];

    protected $hidden = ['id', 'updated_at'];
}
