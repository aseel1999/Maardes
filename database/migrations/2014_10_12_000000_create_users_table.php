<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('confirm_password');
            $table->string('mobile')->nullable();
            $table->string('company')->nullable();
            $table->string('country')->nullable();
            $table->string('files')->nullable();
            $table->string('company_files')->nullable();
            $table->enum('type',[
                '1','2','3','4'
            ])->default('1')->comment('1->visitor , 2->organizer , 3->raei,4->viewer')->nullable();
            $table->text('service')->nullable();
            $table->foreignId('package_id')->nullable();
            $table->foreignId('company_id')->nullable();
            $table->string('fb_link')->nullable();
            $table->string('tw_link')->nullable();
            $table->string('inst_link')->nullable();
            $table->string('linked_link')->nullable();
            
            $table->text('bio')->nullable();
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};
