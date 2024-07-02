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
        Schema::create('dummy_purchase_inv_prods', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->integer('v_type_id');
            $table->integer('v_wise_type_id');
            $table->string('subamount')->default('0');
            $table->string('grand_total')->default('0');
            $table->string('paid_amount')->default('0');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dummy_purchase_inv_prods');
    }
};
