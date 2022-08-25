<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserJobsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_jobs', function (Blueprint $table) {
            $table->id();
            $table->string('job_title');
			$table->string('job_id', 50);
			$table->text('job_description'); 
            $table->decimal('salary', $precision = 8, $scale = 2);
			$table->string('location'); 
			$table->string('employment_type'); 
			$table->string('languages');
			$table->string('skills'); 
			$table->string('user_id', 50); 
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
        Schema::dropIfExists('user_jobs');
    }
}
