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
        Schema::create('paket_soal', function (Blueprint $table) {
            $table->id();
            $table->string('nama_paket');
            $table->string('alias_url');
            $table->longText('prolog_login');
            $table->longText('deskripsi');
            $table->longText('result_message');
            $table->longText('prolog_after_logout');
            $table->date('tgl_tayang');
            $table->date('tgl_selesai_tayang');
            $table->integer('tahun_pelaksanaan');
            $table->boolean('publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('paket_soal');
    }
};
