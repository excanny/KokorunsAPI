<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationAdmin extends Model
{
    use HasFactory;
    protected $fillable = [
    
        's_no', 'association_id', 'sub_admin_id', 'sub_admin_name'
        ];

        protected $hidden = ['id', 'updated_at'];
}
