<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id');
            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->string('name');
            $table->string('slogan');
            $table->text('description');
            $table->string('phone');
            $table->text('address');
            $table->string('banner')->nullable();
            $table->string('opening-day');
            $table->string('closing-day');
            $table->string('opening-time');
            $table->string('closing-time');
            $table->string('p-heading');
            $table->string('p-subheading');
            $table->string('c-heading');
            $table->string('c-subheading');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};
