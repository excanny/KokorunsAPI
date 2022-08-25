<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssociationBranch extends Model
{
    use HasFactory;
    protected $fillable = [
    
        'association_id',
        'branch_id',
        'branch_name',
        'branch_manager',
        'branch_address',
        'branch_state',
        'branch_lga',
        'branch_phone',
        'opening_time',
        'closing_time',
        'opening_week_day',
        'closing_week_day',
        'branch_image'
        ];

        protected $hidden = ['id', 'updated_at'];
}
