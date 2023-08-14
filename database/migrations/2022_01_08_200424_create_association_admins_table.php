<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAssociationAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('association_admins', function (Blueprint $table) {
            $table->id();
            $table->string('s_no', 100);
            $table->string('association_id', 100);
            $table->string('sub_admin_id', 100);
            $table->string('sub_admin_name', 100);
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
        Schema::dropIfExists('association_admins');
    }
}
