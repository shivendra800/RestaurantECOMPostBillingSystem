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
        Schema::create('external_capital_purchase_payment_logs', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id');
            $table->bigInteger('vendor_id');
            $table->string('previous_balance');
            $table->string('total_billing');
            $table->string('grand_total');
            $table->string('paid_amount');
            $table->string('remaining_amount');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_capital_purchase_payment_logs');
    }
};
