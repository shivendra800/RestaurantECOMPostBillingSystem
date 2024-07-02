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
        Schema::create('bar_use_stocklogs', function (Blueprint $table) {
            $table->id();
            $table->string('bar_current_stock');
            $table->string('usestock_stock');
            $table->string('product_id');
            $table->string('unit_id');
            $table->string('after_use_stock');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar_use_stocklogs');
    }
};
