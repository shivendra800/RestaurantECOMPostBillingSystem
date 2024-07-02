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
        Schema::create('external_capital_purchase_invs', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->integer('v_type_id');
            $table->string('grand_total');
            $table->string('paid_amount');
            $table->string('remaining_amount');
            $table->string('previous_amount');
            $table->string('total_bill');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_capital_purchase_invs');
    }
};
