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
        Schema::create('external_product_use_log_mangs', function (Blueprint $table) {
            $table->id();
            $table->integer('product_id');
            $table->string('before_transfer_qty');
            $table->string('transfer_qty');
            $table->string('after_transfer_qty');
            $table->string('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('external_product_use_log_mangs');
    }
};
