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
        Schema::create('bar_table_order_items', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('item_id');
            $table->float('price');
            $table->string('item_qty');
            $table->string('amount');
            $table->string('no_of_qty_buy');
            $table->string('no_qty_buy_to_free');
            $table->string('item_serve_time');
            $table->string('order_item_status');
            $table->string('order_waste_remark');
            $table->string('order_type');   
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar_table_order_items');
    }
};
