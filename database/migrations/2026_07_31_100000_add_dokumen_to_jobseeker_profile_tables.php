<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Tambah kolom dokumen (bukti) pada tabel-tabel atribut jobseeker.
     * Nullable agar data lama tetap aman; kewajiban diisi diberlakukan
     * pada validasi form (wajib untuk entri baru).
     */
    public function up(): void
    {
        Schema::table('organisasi', function (Blueprint $table) {
            $table->string('dokumen', 255)->nullable()->after('keterangan');
        });
        Schema::table('bahasa', function (Blueprint $table) {
            $table->string('dokumen', 255)->nullable()->after('keterangan');
        });
        Schema::table('riwayat_kerja', function (Blueprint $table) {
            $table->string('dokumen', 255)->nullable()->after('keterangan');
        });
        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->string('dokumen', 255)->nullable()->after('keterangan');
        });
    }

    public function down(): void
    {
        Schema::table('organisasi', fn (Blueprint $table) => $table->dropColumn('dokumen'));
        Schema::table('bahasa', fn (Blueprint $table) => $table->dropColumn('dokumen'));
        Schema::table('riwayat_kerja', fn (Blueprint $table) => $table->dropColumn('dokumen'));
        Schema::table('riwayat_pendidikan', fn (Blueprint $table) => $table->dropColumn('dokumen'));
    }
};
