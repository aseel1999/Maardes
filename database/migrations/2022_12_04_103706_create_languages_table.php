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
        if (!Schema::hasTable('languages')) {
        Schema::create('languages', function (Blueprint $table) {
            $table->id();
            $table->string('lang');
            $table->timestamps();
            
        });
        DB::table('languages')->insert([
            ['lang' => 'en'],
            ['lang' => 'ar'],
        ]);
    }
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
};
