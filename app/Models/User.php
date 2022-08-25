<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Tymon\JWTAuth\Contracts\JWTSubject;

class User extends Authenticatable implements JWTSubject
    {
        use Notifiable;

        /**
         * The attributes that are mass assignable.
         *
         * @var array
         */
        protected $fillable = [
            'user_id',
            'first_name',
            'last_name',
            'email',
            'password',
            'phone',
            'email_profile_setup',
            'age_range',
            'address',
            'profession',
            'dob', 'address', 'gender', 'marital_status', 'disabled', 'educational_qualification', 'profession', 'other_professions1', 'languages1', 'current_employer', 'preferred_job', 'preferred_job2', 'preferred_job3', 'preferred_job4', 'preferred_job_location_state', 'preferred_job_location_lga', 'profession', 'availability_start_date', 'minimum_salary', 'employment_type', 'employment_status', 'educational_qualification', 'active', 'state', 'lga', 'profile_image', 'about', 'background_image', 'text_colour', 'website' ,
            'employers_address', 'disability_details',
    
        ];

        /**
         * The attributes that should be hidden for arrays.
         *
         * @var array
         */
        protected $hidden = [
            'password', 'remember_token', 'id', 'updated_at', 'languages2'
            , 'languages2'
            , 'languages3'
            , 'languages4'
            , 'languages5'
            , 'other_professions2'
            , 'other_professions3'
            , 'other_professions4'
        ];

         /**
         * The attributes that should be cast to native types.
         *
         * @var array
         */
        protected $casts = [
            'email_verified_at' => 'datetime',
        ];


        public function getJWTIdentifier()
        {
            return $this->getKey();
        }
        public function getJWTCustomClaims()
        {
            return [];
        }
    }
