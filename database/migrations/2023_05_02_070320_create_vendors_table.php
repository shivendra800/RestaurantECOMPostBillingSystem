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
        Schema::create('vendors', function (Blueprint $table) {
            $table->id();
            $table->string('vendor_type');
            $table->longText('v_wallet');
            $table->string('v_firm_name');
            $table->string('vendor_name');
            $table->string('v_email');
            $table->string('v_address');
            $table->string('v_city');
            $table->string('v_state');
            $table->string('v_pincode');
            $table->string('v_phone_no');
            $table->string('v_gstnin_no')->nullable();
            $table->tinyInteger('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vendors');
    }
};
