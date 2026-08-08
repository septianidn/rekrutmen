<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Normalisasi jenjang pendidikan: buat tabel master `jenjang` (yang selama
     * ini di-scaffold tanpa migrasi), lalu ubah `riwayat_pendidikan.jenjang`
     * (teks bebas varchar 5) menjadi relasi FK `jenjang_id` -> `jenjang.id`.
     */
    public function up(): void
    {
        if (! Schema::hasTable('jenjang')) {
            Schema::create('jenjang', function (Blueprint $table) {
                $table->id();
                $table->string('nama_jenjang', 20)->unique();
                $table->timestamps();
            });
        }

        // Katalog standar jenjang pendidikan Indonesia (idempoten).
        foreach (['SD', 'SMP', 'SMA', 'SMK', 'D3', 'D4', 'S1', 'S2', 'S3'] as $nama) {
            DB::table('jenjang')->updateOrInsert(
                ['nama_jenjang' => $nama],
                ['created_at' => now(), 'updated_at' => now()]
            );
        }

        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->unsignedBigInteger('jenjang_id')->nullable()->after('jenjang');
        });

        // Backfill: tiap nilai teks unik dipetakan ke master (dibuat bila non-standar).
        $texts = DB::table('riwayat_pendidikan')
            ->whereNotNull('jenjang')->where('jenjang', '<>', '')
            ->distinct()->pluck('jenjang');
        foreach ($texts as $t) {
            $nama = mb_substr(trim($t), 0, 20);
            if ($nama === '') {
                continue;
            }
            $id = DB::table('jenjang')->where('nama_jenjang', $nama)->value('id');
            if (! $id) {
                $id = DB::table('jenjang')->insertGetId([
                    'nama_jenjang' => $nama,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('riwayat_pendidikan')->where('jenjang', $t)->update(['jenjang_id' => $id]);
        }

        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->foreign('jenjang_id')->references('id')->on('jenjang')->nullOnDelete();
            $table->dropColumn('jenjang');
        });
    }

    public function down(): void
    {
        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->string('jenjang', 5)->nullable()->after('jenjang_id');
        });

        foreach (DB::table('riwayat_pendidikan')->whereNotNull('jenjang_id')->get(['id', 'jenjang_id']) as $row) {
            $nama = DB::table('jenjang')->where('id', $row->jenjang_id)->value('nama_jenjang');
            DB::table('riwayat_pendidikan')->where('id', $row->id)
                ->update(['jenjang' => $nama ? mb_substr($nama, 0, 5) : null]);
        }

        Schema::table('riwayat_pendidikan', function (Blueprint $table) {
            $table->dropForeign(['jenjang_id']);
            $table->dropColumn('jenjang_id');
        });

        // Tabel master `jenjang` sengaja tidak di-drop otomatis agar data master
        // tidak hilang; hapus manual bila memang dikehendaki.
    }
};
