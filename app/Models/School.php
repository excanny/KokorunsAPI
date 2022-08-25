<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;
    protected $fillable = [
    
        'school_name', 'school_id', 'cac', 'school_address', 'school_email', 'phone', 'website', 'main_office_location_state', 'main_office_location_lga', 'about', 'school_industry', 'school_industry2', 'school_industry3', 'school_type', 'school_size', 'linkedin', 'facebook', 'twitter', 'school_director', 'instagram', 'founded_year', 'field', 'tags', 'author', 'logo'
        ];

        protected $hidden = ['id', 'updated_at', ];
}
