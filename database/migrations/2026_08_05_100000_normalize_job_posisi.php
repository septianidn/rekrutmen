<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Normalisasi posisi lowongan: dari kolom teks bebas `job.posisi`
     * menjadi relasi FK `job.posisi_id` -> `posisi.id`.
     *
     * Nilai teks yang sudah ada dipetakan (dibuat bila belum ada) ke baris
     * master `posisi`, lalu kolom teks lama dibuang.
     */
    public function up(): void
    {
        // Master lama hanya varchar(25); validasi form lowongan mengizinkan
        // sampai 50. Lebarkan agar judul posisi wajar tetap muat.
        DB::statement('ALTER TABLE posisi MODIFY nama_posisi VARCHAR(100) NOT NULL');

        Schema::table('job', function (Blueprint $table) {
            $table->unsignedBigInteger('posisi_id')->nullable()->after('posisi');
        });

        // Backfill: tiap nilai teks unik dipetakan ke master (dibuat bila belum ada).
        $names = DB::table('job')
            ->whereNotNull('posisi')
            ->where('posisi', '<>', '')
            ->distinct()
            ->pluck('posisi');

        foreach ($names as $name) {
            $clean = mb_substr(trim($name), 0, 100);
            if ($clean === '') {
                continue;
            }
            $id = DB::table('posisi')->where('nama_posisi', $clean)->value('id');
            if (! $id) {
                $id = DB::table('posisi')->insertGetId([
                    'nama_posisi' => $clean,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
            DB::table('job')->where('posisi', $name)->update(['posisi_id' => $id]);
        }

        Schema::table('job', function (Blueprint $table) {
            $table->foreign('posisi_id')->references('id')->on('posisi')->nullOnDelete();
            $table->dropColumn('posisi');
        });
    }

    public function down(): void
    {
        Schema::table('job', function (Blueprint $table) {
            $table->string('posisi', 255)->nullable()->after('posisi_id');
        });

        foreach (DB::table('job')->whereNotNull('posisi_id')->get(['id', 'posisi_id']) as $row) {
            $name = DB::table('posisi')->where('id', $row->posisi_id)->value('nama_posisi');
            DB::table('job')->where('id', $row->id)->update(['posisi' => $name]);
        }

        Schema::table('job', function (Blueprint $table) {
            $table->dropForeign(['posisi_id']);
            $table->dropColumn('posisi_id');
        });

        DB::statement('ALTER TABLE posisi MODIFY nama_posisi VARCHAR(25) NOT NULL');
    }
};
