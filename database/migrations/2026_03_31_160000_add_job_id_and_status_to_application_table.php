<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('application', function (Blueprint $table) {
            $table->foreignId('job_id')->after('jobseeker_id')->constrained('job');
            $table->enum('status', ['pending', 'accepted', 'rejected'])->default('pending')->after('tanggal_apply');
        });
    }

    public function down(): void
    {
        Schema::table('application', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->dropColumn(['job_id', 'status']);
        });
    }
};
