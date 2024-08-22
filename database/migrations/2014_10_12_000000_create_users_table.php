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
            $table->string('generic_id');
            $table->string('name');
            $table->string('username')->unique();
            $table->string('email')->unique();
            $table->string('user_genders_id')->nullable();
            $table->string('occupation')->nullable();
            $table->text('location')->nullable();
            $table->string('age')->nullable(); //Json array | ['age' => 25, 'status' => 'hide'] status reference to data_statuses_table
            $table->unsignedBigInteger('facebook_id')->nullable();
            $table->unsignedBigInteger('google_id')->nullable();
            $table->string('password'); //
            $table->unsignedBigInteger('role_id');
            $table->timestamp('email_verified_at')->nullable();
            $table->string('profile_image')->nullable();
            $table->Integer('credit')->default(0);
            $table->Integer('otp')->nullable();
            $table->string('is_otp_valid')->default("no");
            $table->rememberToken();
            $table->timestamps();
        });
    } // 

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
