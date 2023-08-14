<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
    
    'company_name', 'company_id', 'cac', 'company_address', 'company_email', 'phone', 'website', 'main_office_location_state', 'main_office_location_lga', 'about', 'company_industry', 'company_industry2', 'company_industry3', 'company_type', 'company_size', 'linkedin', 'facebook', 'twitter', 'company_director', 'instagram', 'founded_year', 'field', 'tags', 'author', 'logo'
    ];

     protected $hidden = ['id', 'updated_at'];
}
