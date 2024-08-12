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
            $table->Integer('vendor_id'); // vendor_id
            $table->Integer('event_id'); // event_id
            $table->string('services_list'); // Array min:1
            $table->string('subdetails')->nullable(); // Additionals inforation about the service
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
