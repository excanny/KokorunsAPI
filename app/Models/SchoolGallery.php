<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolGallery extends Model
{
    use HasFactory;
    protected $fillable = [
    
        'school_id',
        'user_id',
        'gallery_id',
        'image',
        'image_title',
       
        ];

        protected $hidden = ['id', 'updated_at'];
}
