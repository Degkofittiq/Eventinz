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
            $table->string('generic_id');
            $table->Integer('user_id');
            $table->integer('event_type_id'); // Event type(party for birthday, communion, mariage, etc...) 
            $table->string('vendor_type_id'); // Array min:1 to store all the categories of vendor need for the event
            $table->string('duration'); // In hours or per day
            $table->date('start_date'); //  event's start date
            $table->date('end_date'); //  event's end date
            $table->string('country'); // event's country
            $table->string('state'); //  event's state
            $table->string('city'); //  event's city
            $table->string('subcategory')->nullable(); //  event's subcategory
            $table->Integer('public_or_private')->default(0); //  event's view status(public 0 / private 1)
            $table->string('description')->nullable(); // In hours or per day
            $table->string('vendor_poke')->nullable(); //  Array : nullable(); If the event's author wants one particular vendor
            $table->decimal('total_amount')->nullable(); //  Event's total_amount services amount 
            $table->Integer('is_pay_done')->default(0); //  event's pay status (no 0 / yes 1)
            $table->string('status')->default("No"); //  event's status (Active => Yes / No Active => No) 
            $table->string('cancelstatus')->default("no"); //  cancel status (yes or no) 
            $table->timestamps(); // Created at ...
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
