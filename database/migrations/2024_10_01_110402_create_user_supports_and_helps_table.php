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
        Schema::create('user_supports_and_helps', function (Blueprint $table) {
            $table->id();
            $table->integer('admin_id'); // Admin qui ecrit le commantaire
            $table->integer('users_id'); // Admin qui ecrit le commantaire 
            $table->string('support_subject'); // Admin qui ecrit le commantaire 
            $table->string('support_description'); // Admin qui ecrit le commantaire
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
        Schema::dropIfExists('user_supports_and_helps');
    }
};
