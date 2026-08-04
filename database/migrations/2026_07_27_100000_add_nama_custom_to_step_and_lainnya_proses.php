<?php

use App\Models\Proses;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Add a per-job custom step name column and register the shared
     * "Lainnya" stage in the proses catalog. When an employer picks
     * "Lainnya" as a selection stage, the actual stage name (e.g.
     * "Tes Fisik") is stored in step.nama_custom while proses_id keeps
     * pointing at the single "Lainnya" catalog row (FK stays valid, the
     * catalog is not polluted with per-employer entries).
     */
    public function up(): void
    {
        Schema::table('step', function (Blueprint $table) {
            $table->string('nama_custom', 100)->nullable()->after('deskripsi');
        });

        Proses::firstOrCreate(['nama_proses' => 'Lainnya']);
    }

    public function down(): void
    {
        Schema::table('step', function (Blueprint $table) {
            $table->dropColumn('nama_custom');
        });
    }
};
