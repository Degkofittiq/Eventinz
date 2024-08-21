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
        Schema::create('event_quotes', function (Blueprint $table) {
            $table->id();
            $table->string('quote_code');
            $table->Integer('event_id');
            $table->Integer('company_id');
            // $table->string('services_list'); // Array min:1
            $table->string('servicename');
            $table->string('subdetails')->nullable(); // Additionals inforation about the service 
            $table->string('travel')->nullable(); // yes or no
            $table->string('type')->default(0); // fixed || not_fixed
            $table->string('duration')->nullable();
            $table->decimal('rate'); // Amount per hours or ... 
            $table->decimal('total'); // Total Amount
            $table->string('obligatory'); // obligatory => yes or no_obligatory => no
            $table->string('status')->nullable(); // accepted or remove (the event's user dont want)
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
        Schema::dropIfExists('event_quotes');
    }
};
