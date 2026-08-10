<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Master akademik `fakultas` & `prodi`, mengikuti struktur modul Tracer
     * Study (agar identik saat digabung):
     *   fakultas(fakultas_id PK, nama_fakultas)
     *   prodi(kode_prodi PK, nama_prodi, fakultas_id FK, jenjang_id FK)
     * `kode_prodi` adalah kode manual (mis. kode prodi DIKTI), bukan auto-increment.
     */
    public function up(): void
    {
        if (! Schema::hasTable('fakultas')) {
            Schema::create('fakultas', function (Blueprint $table) {
                $table->bigIncrements('fakultas_id');
                $table->string('nama_fakultas', 100);
                $table->timestamps();
            });
        }

        if (! Schema::hasTable('prodi')) {
            Schema::create('prodi', function (Blueprint $table) {
                $table->unsignedBigInteger('kode_prodi')->primary();
                $table->string('nama_prodi', 100);
                $table->unsignedBigInteger('fakultas_id');
                $table->unsignedBigInteger('jenjang_id');
                $table->timestamps();

                $table->foreign('fakultas_id')->references('fakultas_id')->on('fakultas')->cascadeOnDelete();
                $table->foreign('jenjang_id')->references('jenjang_id')->on('jenjang')->restrictOnDelete();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('prodi');
        Schema::dropIfExists('fakultas');
    }
};
