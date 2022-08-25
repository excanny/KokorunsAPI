<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompaniesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('company_name', 200);
            $table->string('company_id')->unique();
            $table->string('cac');
            $table->string('company_address');
            $table->string('company_email', 150)->nullable();
            $table->string('phone');
            $table->string('website')->nullable();
            $table->string('main_office_location_state');
            $table->string('main_office_location_lga');
            $table->string('about')->nullable();
            $table->string('company_industry');
            $table->string('company_industry2');
            $table->string('company_industry3');
            $table->string('company_size'); 
            $table->string('company_type');
            $table->string('linkedin')->nullable();
            $table->string('facebook')->nullable();
            $table->string('twitter')->nullable();
            $table->string('instagram')->nullable();
            $table->string('company_director')->nullable(); 
            $table->string('founded_month')->nullable();
            $table->string('founded_year')->nullable();
            $table->string('field')->nullable();
            $table->string('tags')->nullable();
            $table->string('author');
            $table->string('logo')->default('Company_logo.png');
            $table->string('cover_image')->default('Company_DP.png');
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
        Schema::dropIfExists('companies');
    }
}
