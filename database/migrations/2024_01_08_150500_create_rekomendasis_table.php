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

        Schema::create('rekomendasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_id')->constrained('jobseeker');
            $table->string('nama_perekomendasi', 30);
            $table->string('posisi', 20);
            $table->string('no_hp', 14);
            $table->string('alamat', 50);
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekomendasi');
    }
};
