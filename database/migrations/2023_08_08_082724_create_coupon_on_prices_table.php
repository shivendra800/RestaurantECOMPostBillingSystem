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
        Schema::create('coupon_on_prices', function (Blueprint $table) {
            $table->id();
            $table->string('promocode');
            $table->string('remark');
            $table->integer('offer_per');
            $table->integer('order_amount');
            $table->string('start_date');
            $table->string('expiry_date');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('coupon_on_prices');
    }
};
