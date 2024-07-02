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
        Schema::create('take_way_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('order_no');
            $table->integer('staff_id');
            $table->float('sub_total',8, 2);
            $table->float('service_tax',8, 2);
            $table->float('grand_total',8, 2);
            $table->string('order_status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('take_way_orders');
    }
};
