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
        Schema::create('product_wise_coupons', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('promocode');
            $table->string('remark');
            $table->integer('offer_per')->nullable();
            $table->integer('no_of_qty_buy')->nullable();
            $table->integer('no_qty_buy_to_free')->nullable();
            $table->string('start_date');
            $table->string('expiry_date');
            $table->string('no_of_coupon_tobe_generate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_wise_coupons');
    }
};
