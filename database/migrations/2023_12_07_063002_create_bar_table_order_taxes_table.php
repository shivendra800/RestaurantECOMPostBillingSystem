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
        Schema::create('bar_table_order_taxes', function (Blueprint $table) {
            $table->id();
            $table->string('order_no');
            $table->string('tax_name');
            $table->string('tax_percentage');
            $table->string('tax_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bar_table_order_taxes');
    }
};
