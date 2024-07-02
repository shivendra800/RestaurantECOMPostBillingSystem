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
        Schema::create('menu_item_prices', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_cat_id');
            $table->integer('menu_subcat_id');
            $table->string('menu_item_name');
            $table->string('menu_item_price');
            $table->tinyInteger('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_prices');
    }
};
