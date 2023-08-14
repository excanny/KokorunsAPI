<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Message extends Model
{
    use HasFactory;

    protected $fillable = [
        'author',
        'sender_id',
        'sender_name',
        'subject',
        'message',
        'message_id',
        'receiver_id',
        'receiver_name',
        'is_broadcast',
    ];
    
    protected $hidden = ['id', 'updated_at'];
}
