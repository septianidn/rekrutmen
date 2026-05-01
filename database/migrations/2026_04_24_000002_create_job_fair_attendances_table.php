<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_fair_attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_fair_id')->constrained('job_fair')->cascadeOnDelete();
            $table->foreignId('jobseeker_id')->constrained('jobseeker')->cascadeOnDelete();
            $table->string('kode_qr')->unique();
            $table->timestamp('checked_in_at')->nullable();
            $table->timestamps();

            $table->unique(['job_fair_id', 'jobseeker_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_fair_attendances');
    }
};
