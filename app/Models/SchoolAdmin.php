<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SchoolAdmin extends Model
{
    use HasFactory;
    protected $fillable = [
    
        's_no', 'scholl_id', 'sub_admin_id', 'sub_admin_name'
        ];

        protected $hidden = ['id', 'updated_at'];
}
