<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('language_translation', function (Blueprint $table) {
            $table->id();
            $table->integer('language_id');
            $table->string('locale');
            $table->string('name');
            $table->timestamps();
            
        });
        DB::table('language_translation')->insert([
            ['language_id' => '1','locale'=>'en','name'=>'English'],
            ['language_id' => '1','locale'=>'en','name'=>'إنجليزي'],

            ['language_id' => '2','locale'=>'arcomposer require laravel/breeze --dev','name'=>'Arabic'],
            ['language_id' => '2','locale'=>'ar','name'=>'عربي'],


        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('language_translation');
    }
};
