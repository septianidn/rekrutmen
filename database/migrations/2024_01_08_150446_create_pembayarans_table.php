<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')
                ->constrained('employer')
                ->cascadeOnDelete();
            $table->enum('kategori', ['membership', 'event'])->default('membership');
            $table->foreignId('membership_id')
                ->nullable()
                ->constrained('membership')
                ->nullOnDelete();
            $table->unsignedBigInteger('employer_event_id')->nullable();
            $table->decimal('amount', 10, 2);
            $table->enum('status', ['pending', 'lunas', 'gagal', 'expired'])->default('pending');
            $table->string('midtrans_order_id')->unique()->nullable();
            $table->string('midtrans_transaction_id')->nullable();
            $table->text('snap_token')->nullable();
            $table->date('tgl_mulai')->nullable();
            $table->date('tgl_berakhir')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamps();

            $table->index(['employer_id', 'status']);
            $table->index(['kategori', 'status']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pembayaran');
    }
};
