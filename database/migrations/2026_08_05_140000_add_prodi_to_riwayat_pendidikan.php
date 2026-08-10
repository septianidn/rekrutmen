<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tautkan riwayat pendidikan ke master prodi.
     *
     * Sistem melayani pelamar Unand DAN non-Unand, jadi:
     *   - `kode_prodi_id` : FK NULLABLE ke prodi Unand (diisi hanya untuk
     *     pendidikan di Unand) — meniru `alumni.kode_prodi_id` pada Tracer Study.
     *   - `prodi_lain`    : teks bebas nama program studi untuk institusi
     *     non-Unand / prodi yang tidak terdaftar.
     * Laporan "alumni per prodi" cukup GROUP BY kode_prodi_id (otomatis Unand).
     */
    public function up(): void
    {
        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->unsignedBigInteger('kode_prodi_id')->nullable()->after('jenjang_id');
            $table->string('prodi_lain', 100)->nullable()->after('kode_prodi_id');

            $table->foreign('kode_prodi_id')->references('kode_prodi')->on('prodi')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->dropForeign(['kode_prodi_id']);
            $table->dropColumn(['kode_prodi_id', 'prodi_lain']);
        });
    }
};
