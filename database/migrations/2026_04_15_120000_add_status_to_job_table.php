<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('job', function (Blueprint $table) {
            $table->enum('status', ['active', 'closed'])->default('active')->after('application_deadline');
        });
    }

    public function down(): void
    {
        Schema::table('job', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
};
