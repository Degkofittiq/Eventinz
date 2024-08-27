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
    { // All companies information
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('users_id'); 
            $table->string('name');
            $table->string('tagline')->nullable();
            $table->string('country');
            $table->string('state');
            $table->string('city');
            $table->json('images')->nullable(); // Colonne pour stocker les informations des images en JSON
            $table->unsignedBigInteger('vendor_service_types_id')->nullable(); // If vendor, her service type (single or multiple)
            $table->text('vendor_categories_id')->nullable(); // If vendor, her category list (DJ, DECORATION, ...) based on service type (single or multiple) 
            $table->text('subscriptions_id')->nullable(); // If vendor, her subscriptions
            $table->Integer('is_subscribed')->default(0);
            $table->string('subscription_start_date')->nullable();
            $table->string('subscription_end_date')->nullable();
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
        Schema::dropIfExists('companies');
    }
};
