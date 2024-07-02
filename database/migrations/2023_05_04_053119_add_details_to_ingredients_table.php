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
        Schema::table('ingredients', function (Blueprint $table) {
            $table->integer('v_type_id');
            $table->integer('v_tye_wise_id');
            $table->integer('c_type_id');
            $table->integer('c_tye_wise_id');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredient', function (Blueprint $table) {
            //
        });
    }
};
