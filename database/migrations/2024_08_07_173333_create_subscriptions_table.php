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
    { // All Subscription for vendor
        Schema::create('subscriptions', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // name description vendor_service_types_id price duration features
            $table->text('description');
            $table->unsignedBigInteger('vendor_service_types_id'); // Single or Multiples 
            $table->decimal('price');
            $table->integer('credits')->nullable();
            $table->Integer('duration'); // Preriod in months
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
        Schema::dropIfExists('subscriptions');
    }
};
