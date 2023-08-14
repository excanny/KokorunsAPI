<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCompanyBranchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('company_branches', function (Blueprint $table) {
            $table->id();
            $table->string('company_id');
            $table->string('branch_id');
            $table->string('branch_name');
            $table->string('branch_manager');
            $table->string('branch_address');
            $table->string('branch_state');
            $table->string('branch_lga');
            $table->string('branch_phone');
            $table->time('opening_time');
            $table->time('closing_time');
            $table->string('opening_week_day');
            $table->string('closing_week_day');
            $table->string('branch_image'); 
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
        Schema::dropIfExists('company_branches');
    }
}
