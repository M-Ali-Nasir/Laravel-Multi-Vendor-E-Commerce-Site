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
        Schema::create('vendor_fbs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('vendor_id');
            $table->text('token')->nullable();
            $table->string('facebook_app_id')->nullable();
            $table->string('facebook_page_id')->nullable();

            $table->foreign('vendor_id')->references('id')->on('vendors')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_fbs');
    }
};
