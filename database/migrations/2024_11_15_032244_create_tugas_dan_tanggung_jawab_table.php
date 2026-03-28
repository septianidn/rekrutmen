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
        Schema::create('tugas_dan_tanggung_jawab', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job');
            $table->string('tugas');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tugas_dan_tanggung_jawab');
    }
};
