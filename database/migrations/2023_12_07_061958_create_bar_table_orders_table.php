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
        Schema::create('bar_table_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->integer('bar_table_id');
            $table->integer('staff_id');
            $table->integer('total_no_person_intable');
            $table->integer('sub_total');
            $table->integer('subtotalwithoffer');
            $table->integer('total_tax');
             $table->string('grand_total');
             $table->integer('coupon_per');
             $table->integer('coupon_avail_amount');
             $table->integer('coupon_code');
             $table->integer('order_status');
            $table->integer('payment_mode');
            $table->integer('payment_id');
            $table->integer('taken_cash_amount');
            $table->integer('given_change_amount');
            $table->integer('mobile_no');
            $table->integer('image_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar_table_orders');
    }
};
