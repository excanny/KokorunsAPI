<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->timestamps();
        });

        $data = [
            ['name'=> 'Yoruba'],
            ['name'=> 'Hausa'],
            ['name'=> 'Igbo'],
            ['name'=> 'Pidgin English'],
            ['name'=> 'French'],
            ['name'=> 'Tiv'],
            ['name'=> 'Fulfulde'],
            ['name'=> 'Efik-Ibibio'],
            ['name'=> 'Ijaw-Izon'],
            ['name'=> 'Urhobo'],
            ['name'=> 'Sign Language (English)'],
            ['name'=> 'Sign Language (Hausa)'],
            ['name'=> 'Kanuri'],
            ['name'=> 'Edo'],
            ['name'=> 'Igala'],
            ['name'=> 'Nupe-Ebira'],
            ['name'=> 'Birom'],
            ['name'=> 'Idoma'],
            ['name'=> 'Itsekiri'],
            ['name'=> 'British English'],
            ['name'=> 'Spanish'],
            ['name'=> 'Mandarin']
            
        ];

        DB::table('languages')->insert($data);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('languages');
    }
}
