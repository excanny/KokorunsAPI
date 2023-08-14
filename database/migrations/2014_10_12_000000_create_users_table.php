<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('first_name',20)->nullable();
            $table->string('last_name',20)->nullable();
            $table->string('user_id',100);
            $table->string('password');
            $table->string('email')->unique();
            $table->string('email_profile_setup', 50)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('phone',20)->nullable();
            $table->string('age_range',30)->nullable();
            $table->text('address')->nullable();
            $table->string('profession',80)->nullable();
            $table->string('employment_type',30)->nullable();
            $table->string('employment_status',30)->nullable();
            $table->string('educational_qualification',80)->nullable();
            $table->decimal('minimum_salary')->default('0')->nullable();
            $table->string('state',30)->nullable();
            $table->string('lga',30)->nullable();
            $table->tinyInteger('active')->default('0');
            $table->string('profile_id', 150)->nullable();
            $table->string('profile_image',150)->default('User_DP.png');
            $table->string('background_image',150)->nullable();
            $table->string('text_colour',20)->nullable();
            $table->string('gender',20)->nullable();
            $table->string('marital_status',30)->nullable();
            $table->string('preferred_job_location_state',30)->nullable();
            $table->string('preferred_job_location_lga',30)->nullable();
            $table->string('preferred_job',80)->nullable();
            $table->text('other_professions1')->nullable(); 
            $table->string('other_professions2',80)->nullable();
            $table->string('other_professions3',80)->nullable();
            $table->string('other_professions4',80)->nullable();
            $table->date('availability_start_date')->nullable();
            $table->string('current_employer',80)->nullable();
            $table->string('disabled',20)->nullable();
            $table->text('languages1')->nullable();
            $table->string('languages2',80)->nullable();
            $table->string('languages3',80)->nullable();
            $table->string('languages4',80)->nullable();
            $table->string('languages5',80)->nullable();
            $table->text('about')->nullable();
            $table->string('cookie')->nullable();
            $table->string('website')->nullable(); 
            $table->date('dob')->nullable();
            $table->text('employers_address')->nullable(); 
            $table->text('disability_details')->nullable(); 
            $table->string('cover_image')->default('Cover_DP.png'); 
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}
