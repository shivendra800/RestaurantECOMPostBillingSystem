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
        Schema::create('restaurant_store_rooms', function (Blueprint $table) {   

            $table->id();
            $table->integer('prdouct_id');
            $table->integer('p_unit_id');
            $table->integer('store_qty');
            $table->string('store_manager');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('restaurant_store_rooms');
    }
};
