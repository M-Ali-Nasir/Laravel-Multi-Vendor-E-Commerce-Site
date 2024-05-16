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
        Schema::table('order_addresses', function (Blueprint $table) {
            //
            $table->integer('shipping_phone');
            $table->integer('billing_phone')->nullable();
            $table->string('shipping_country');
            $table->string('billing_country')->nullable();
            $table->string('shipping_state');
            $table->string('billing_state')->nullable();
            $table->integer('shipping_zip');
            $table->integer('billing_zip')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_addresses', function (Blueprint $table) {
            //
            $table->dropColumn('shipping_phone');
            $table->dropColumn('billing_phone');
            $table->dropColumn('shipping_country');
            $table->dropColumn('billing_country');
            $table->dropColumn('shipping_state');
            $table->dropColumn('billing_state');
            $table->dropColumn('shipping_zip');
            $table->dropColumn('billing_zip');
        });
    }
};
