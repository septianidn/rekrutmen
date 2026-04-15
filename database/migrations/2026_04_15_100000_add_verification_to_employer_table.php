<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('employer', function (Blueprint $table) {
            $table->enum('verification_status', ['pending', 'approved', 'rejected'])
                ->default('pending')
                ->after('website');
            $table->timestamp('verified_at')->nullable()->after('verification_status');
            $table->text('verification_note')->nullable()->after('verified_at');
            $table->foreignId('verified_by')->nullable()->constrained('users')->nullOnDelete()->after('verification_note');
        });
    }

    public function down(): void
    {
        Schema::table('employer', function (Blueprint $table) {
            $table->dropForeign(['verified_by']);
            $table->dropColumn(['verification_status', 'verified_at', 'verification_note', 'verified_by']);
        });
    }
};
