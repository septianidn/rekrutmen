<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_fair_booth_scans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_fair_id')->constrained('job_fair')->cascadeOnDelete();
            $table->unsignedBigInteger('job_fair_job_id');
            $table->foreign('job_fair_job_id')->references('id')->on('job_fair_job')->cascadeOnDelete();
            $table->foreignId('jobseeker_id')->constrained('jobseeker')->cascadeOnDelete();
            $table->foreignId('job_id')->constrained('job')->cascadeOnDelete();
            $table->enum('status', ['menunggu', 'dipanggil', 'sedang_diproses', 'selesai', 'tidak_hadir'])
                  ->default('menunggu');
            $table->timestamp('dipanggil_at')->nullable();
            $table->timestamp('selesai_at')->nullable();
            $table->timestamp('tidak_hadir_at')->nullable();
            $table->text('catatan')->nullable();
            $table->timestamps();

            $table->unique(['job_fair_job_id', 'jobseeker_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_fair_booth_scans');
    }
};
