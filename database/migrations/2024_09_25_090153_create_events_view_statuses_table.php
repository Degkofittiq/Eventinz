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
        Schema::create('events_view_statuses', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // private - public
            $table->string('description'); // if public (this status allow notification to all vendors in the categories that you choosed ) 
            $table->decimal('price')->nullable(); // if the event is on private, the system should be send back a price
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
        Schema::dropIfExists('events_view_statuses');
    }
};
