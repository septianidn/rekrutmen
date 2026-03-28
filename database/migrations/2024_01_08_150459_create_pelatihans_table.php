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

        Schema::create('pelatihan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_id')->constrained('jobseeker');
            $table->string('nama_pelatihan', 50);
            $table->string('tahun', 4);
            $table->string('sertifikat', 250);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pelatihan');
    }
};
