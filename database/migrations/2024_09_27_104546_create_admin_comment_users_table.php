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
        Schema::create('admin_comment_users', function (Blueprint $table) {
            $table->id();
            $table->integer('author_id'); // Admin qui ecrit le commantaire
            $table->integer('user_id'); // Lutilisateur
            $table->string('comment'); // Contenu du commentaire
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
        Schema::dropIfExists('admin_comment_users');
    }
};
