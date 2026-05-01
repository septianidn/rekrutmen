<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job_fair_job', function (Blueprint $table) {
            $table->string('lokasi_booth')->nullable()->after('status');
            $table->string('kode_booth')->nullable()->unique()->after('lokasi_booth');
        });
    }

    public function down(): void
    {
        Schema::table('job_fair_job', function (Blueprint $table) {
            $table->dropUnique(['kode_booth']);
            $table->dropColumn(['lokasi_booth', 'kode_booth']);
        });
    }
};
