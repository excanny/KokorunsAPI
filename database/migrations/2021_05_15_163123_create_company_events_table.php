<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_events', function (Blueprint $table) {
            $table->id();
            $table->string('event_id');
            $table->string('company_id');
            $table->dateTime('from');
            $table->dateTime('to');
            $table->string('title');
            $table->string('event_link')->nullable();
            $table->string('author');
            $table->string('description');
            $table->string('event_type');
            $table->string('event_industry');
            $table->string('event_price1');
            $table->string('event_price2');
            $table->string('event_address');
            $table->string('event_state');
            $table->string('event_lga');
            $table->string('event_image1');
            $table->string('event_logo');
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
        Schema::dropIfExists('company_events');
    }
}
