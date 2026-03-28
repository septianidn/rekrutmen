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
        Schema::table('employer', function (Blueprint $table) {
            $table->string('alamat_perusahaan');
            $table->string('telp_perusahaan');
            $table->string('website');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('employer', function (Blueprint $table) {
            //
        });
    }
};
