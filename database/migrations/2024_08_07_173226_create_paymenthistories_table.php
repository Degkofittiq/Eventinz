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
    { // History of all payment // payment_type => event or subscription
        Schema::create('paymenthistories', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('payment_id');
            $table->string('payment_type'); // vendor_subscriptions / event_create
            $table->date('payment_date');
            $table->decimal('amount');
            $table->String('paymentmethod');
            $table->String('currency'); // Euro , Dollar, XOF, ... 
            $table->String('description'); 
            $table->string('status'); // Success or Faield 
            $table->String('phone_number_or_email'); // it's depend of paypal or momo
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
        Schema::dropIfExists('paymenthistories');
    }
};
