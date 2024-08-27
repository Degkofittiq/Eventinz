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
        Schema::create('services', function (Blueprint $table) {
            $table->id();
            $table->Integer('company_id');
            $table->string('servicename');
            $table->string('type');
            $table->decimal('rate'); // Amount per hours or ...
            $table->string('travel')->default("no"); // yes or no
            $table->string('duration'); //
            $table->decimal('service_price'); // Amount per hours or ...
            $table->string('is_pay_by_hour')->default('no'); // T & M => yes or no 
            $table->text('subdetails'); // subdetails
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
        Schema::dropIfExists('services');
    }
};
