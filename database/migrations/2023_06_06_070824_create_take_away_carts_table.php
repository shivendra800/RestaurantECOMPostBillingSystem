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
        Schema::create('take_away_carts', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->integer('category_id');
            $table->integer('subcategory_id');
            $table->integer('item_id');
            $table->float('price');
            $table->string('item_qty');
            $table->string('amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('take_away_carts');
    }
};
