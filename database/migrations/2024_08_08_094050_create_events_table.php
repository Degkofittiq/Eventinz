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
        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->Integer('user_id');
            $table->integer('event_type_id'); // Event type(party for birthday, communion, mariage, etc...)
            $table->integer('vendor_type_id'); // Array min:1 to store all the categories of vendor need for the event
            $table->string('duration'); // In hours or per day
            $table->string('start_date'); //  event's start date
            $table->string('end_date'); //  event's end date
            $table->string('country'); // event's country
            $table->string('state'); //  event's state
            $table->string('description')->nullable(); // In hours or per day
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
        Schema::dropIfExists('events');
    }
};
