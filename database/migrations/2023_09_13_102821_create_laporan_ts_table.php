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
        Schema::create('laporan_ts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('paket_soal_id')->unsigned()->index();
            $table->foreign('paket_soal_id')->references('id')->on('paket_soal')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('deskripsi');
        
            $table->string('lokasi_laporan');
            $table->boolean('published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_ts');
    }
};
