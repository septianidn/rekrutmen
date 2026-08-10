<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Selaraskan PK tabel `jenjang` dari `id` menjadi `jenjang_id` agar SAMA
     * dengan struktur modul Tracer Study (fakultas_id / jenjang_id / kode_prodi),
     * sehingga saat kedua modul digabung tabel master akademiknya identik.
     *
     * FK `riwayat_pendidikan.jenjang_id` dilepas dulu, kolom PK di-rename via
     * SQL mentah (mempertahankan PK + AUTO_INCREMENT), lalu FK dipasang ulang
     * menunjuk ke `jenjang.jenjang_id`.
     */
    public function up(): void
    {
        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->dropForeign(['jenjang_id']);
        });

        DB::statement('ALTER TABLE jenjang CHANGE id jenjang_id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');

        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->foreign('jenjang_id')->references('jenjang_id')->on('jenjang')->nullOnDelete();
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->dropForeign(['jenjang_id']);
        });

        DB::statement('ALTER TABLE jenjang CHANGE jenjang_id id BIGINT UNSIGNED NOT NULL AUTO_INCREMENT');

        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->foreign('jenjang_id')->references('id')->on('jenjang')->nullOnDelete();
        });
    }
};
