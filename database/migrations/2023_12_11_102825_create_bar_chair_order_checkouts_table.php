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
        Schema::create('bar_chair_order_checkouts', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->integer('chair_id');       
            $table->string('sub_total');
            $table->string('total_tax');
             $table->string('grand_total');
             $table->string('order_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar_chair_order_checkouts');
    }
};
