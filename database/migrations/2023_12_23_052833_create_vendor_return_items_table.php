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
        Schema::create('vendor_return_items', function (Blueprint $table) {
            $table->id();
            $table->integer('vendor_id');
            $table->integer('return_product_id');
            $table->string('return_price');
            $table->string('return_qty');
            $table->string('return_total_amt');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendor_return_items');
    }
};
