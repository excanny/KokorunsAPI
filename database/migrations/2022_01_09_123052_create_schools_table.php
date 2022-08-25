<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSchoolsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('schools', function (Blueprint $table) {
            $table->id();
            $table->string('school_name', 200);
            $table->string('school_id')->unique();
            $table->string('cac');
            $table->string('school_address');
            $table->string('school_email', 150)->nullable();
            $table->string('phone');
            $table->string('website')->nullable();
            $table->string('main_office_location_state');
            $table->string('main_office_location_lga');
            $table->string('about')->nullable();
            $table->string('school_industry');
            $table->string('school_industry2');
            $table->string('school_industry3');
            $table->string('school_size'); 
            $table->string('school_type');
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('school_director')->nullable(); 
            $table->string('founded_month')->nullable();
            $table->string('founded_year')->nullable();
            $table->string('field')->nullable();
            $table->string('tags')->nullable();
            $table->string('author');
            $table->string('logo')->default('School_logo.png');
            $table->string('cover_image')->default('School_DP.png'); 
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
        Schema::dropIfExists('schools');
    }
}
