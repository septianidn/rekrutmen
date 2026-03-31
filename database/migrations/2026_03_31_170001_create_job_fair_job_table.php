<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('job_fair_job', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_fair_id')->constrained('job_fair')->cascadeOnDelete();
            $table->foreignId('job_id')->constrained('job')->cascadeOnDelete();
            $table->foreignId('employer_id')->constrained('employer');
            $table->enum('status', ['pending', 'approved', 'rejected'])->default('pending');
            $table->timestamps();

            $table->unique(['job_fair_id', 'job_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('job_fair_job');
    }
};
