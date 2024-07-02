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
        Schema::create('menu_item_configurations', function (Blueprint $table) {
            $table->id();
            $table->integer('menu_item_id');
            $table->integer('ingredient_id');
            $table->integer('unit_id');
            $table->string('use_weight');
            $table->string('outputKilograms');
            $table->string('outputLiters');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_item_configurations');
    }
};
