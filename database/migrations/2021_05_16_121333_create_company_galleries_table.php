<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyGalleriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_galleries', function (Blueprint $table) {
            $table->id();
            $table->string('company_id');
            $table->string('user_id');
            $table->string('gallery_id');
            $table->string('image');
            $table->string('image_title');
            $table->string('date'); 
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
        Schema::dropIfExists('company_galleries');
    }
}
