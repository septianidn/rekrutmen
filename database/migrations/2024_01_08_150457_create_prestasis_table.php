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
        Schema::disableForeignKeyConstraints();

        Schema::create('prestasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_id')->constrained('jobseeker');
            $table->string('nama_penghargaan', 40);
            $table->string('tahun', 4);
            $table->string('dokumen', 250);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prestasi');
    }
};
