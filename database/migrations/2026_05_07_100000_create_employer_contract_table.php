<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('employer_contract', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')
                ->constrained('employer')
                ->cascadeOnDelete();
            $table->date('tanggal_mulai');
            $table->date('tanggal_berakhir');
            $table->string('mou_file');
            $table->text('catatan')->nullable();
            $table->enum('status', ['active', 'expired', 'revoked'])->default('active');
            $table->foreignId('created_by')
                ->nullable()
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamps();

            $table->index(['employer_id', 'status']);
            $table->index('tanggal_berakhir');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('employer_contract');
    }
};
