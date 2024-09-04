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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->Integer('event_id');
            $table->Integer('user_id');
            $table->Integer('review_cible');
            $table->text('review_content');
            $table->date('date_review'); //Carbon date and time 
            $table->Integer('start_for_cibe'); // Rate
            $table->string('status')->nullable(); // Hide or Show
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
        Schema::dropIfExists('reviews');
    }
};
