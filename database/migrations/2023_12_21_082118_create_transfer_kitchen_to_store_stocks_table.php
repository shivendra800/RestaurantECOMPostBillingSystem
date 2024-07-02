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
        Schema::create('transfer_kitchen_to_store_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('current_stock');
            $table->string('transfer_stock');
            $table->string('remaing_stock_in_bar');
            $table->string('remark')->default('Null');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transfer_kitchen_to_store_stocks');
    }
};
