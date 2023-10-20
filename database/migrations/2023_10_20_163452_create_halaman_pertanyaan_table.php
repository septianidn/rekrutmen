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
        Schema::create('halaman_pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('paket_soal_id')->unsigned()->index();
            $table->foreign('paket_soal_id')->references('id')->on('paket_soal')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('urutan')->length(2);
            $table->string('nama_halaman', 50);
            $table->timestamps();

            $table->unique(['paket_soal_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('halaman_pertanyaan');
    }
};
