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
        Schema::create('update_spoil_expire_stocks', function (Blueprint $table) {
            $table->id();
            $table->string('product_id');
            $table->string('unit_id');
            $table->string('current_stock');
            $table->string('spoil_expire_stock');
            $table->string('after_spoil_expire_totalstock');
            $table->string('remark');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('update_spoil_expire_stocks');
    }
};
