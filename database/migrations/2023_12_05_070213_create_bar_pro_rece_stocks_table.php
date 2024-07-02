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
        Schema::create('bar_pro_rece_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->integer('unit_id');
            $table->integer('bar_stock_qty');
            $table->integer('consumption_qty');
            $table->integer('usestock_stock');
            $table->integer('waste_qty');
            $table->longText('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar_pro_rece_stocks');
    }
};
