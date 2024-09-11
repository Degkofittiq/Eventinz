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
        Schema::create('content_images_management', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Var name
            $table->string('page'); // location page
            $table->string('type'); // Icon, SVG, PNG, JPEG, ...
            $table->text('path'); // s3 Storage path
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
        Schema::dropIfExists('content_images_management');
    }
};
