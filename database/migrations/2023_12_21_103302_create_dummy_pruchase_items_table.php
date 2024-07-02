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
        Schema::create('dummy_pruchase_items', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('purchase_inv_prods_id');
            $table->string('invoice_id');
            $table->bigInteger('vendor_id');
            $table->bigInteger('prod_id');
            $table->string('unit');
            $table->string('qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('dummy_pruchase_items');
    }
};
