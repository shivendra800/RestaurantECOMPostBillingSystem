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
        Schema::create('purchase_inv_prods', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('unit_id');
            $table->integer('v_type_id');
            $table->integer('v_wise_type_id');
            $table->integer('c_type_id');
            $table->integer('c_wise_type_id');
            $table->string('price');
            $table->string('qty');
            $table->string('amount');
            $table->string('grand_total');
            $table->mediumText('paid_amount');
            $table->mediumText('remaining_amount');
            $table->mediumText('previous_amount');
            $table->mediumText('total_bill');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_inv_prods');
    }
};
