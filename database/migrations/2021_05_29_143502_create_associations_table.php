<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('associations', function (Blueprint $table) {
            $table->id();
            $table->string('association_name');
            $table->string('association_id')->unique();
            $table->string('cac');
            $table->string('association_address');
            $table->string('association_director')->nullable();
            $table->string('association_email')->nullable();
            $table->string('association_contact_email')->nullable();
            $table->string('phone');
            $table->string('website');
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('main_office_location_state');
            $table->string('main_office_location_lga');
            $table->text('about')->nullable();
            $table->string('association_industry')->nullable();
            $table->string('association_industry2')->nullable();
            $table->string('association_industry3')->nullable();
            $table->string('association_size')->nullable(); 
            $table->string('association_type')->nullable();
            $table->string('facebook')->nullable();
            $table->string('linkedin')->nullable();
            $table->string('instagram')->nullable();
            $table->string('twitter')->nullable();
            $table->string('tags')->nullable();
            $table->string('field')->nullable();
            $table->string('author');
            $table->string('logo')->default('Association_logo.png');
            $table->string('cover_image')->default('Association_DP.png');
            $table->string('founded_month')->nullable();
            $table->string('founded_year')->nullable();
           
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
        Schema::dropIfExists('associations');
    }
}
