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
        Schema::disableForeignKeyConstraints();

        Schema::create('riwayat_pendidikan', function (Blueprint $table) {
            $table->id();
            $table->foreignId('jobseeker_id')->constrained('jobseeker');
            $table->string('jenjang', 5);
            $table->string('instansi', 50);
            $table->string('indeks_nilai', 4)->nullable();
            $table->text('keterangan');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('riwayat_pendidikan');
    }
};
