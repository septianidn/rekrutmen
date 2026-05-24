<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('pembayaran', function (Blueprint $table) {
            $table->enum('metode_pembayaran', ['midtrans', 'manual'])
                ->default('midtrans')
                ->after('amount');
            $table->foreignId('account_id')
                ->nullable()
                ->after('snap_token')
                ->constrained('account')
                ->nullOnDelete();
            $table->string('bukti_transfer')->nullable()->after('account_id');
            $table->text('admin_note')->nullable()->after('bukti_transfer');
            $table->foreignId('verified_by')
                ->nullable()
                ->after('admin_note')
                ->constrained('users')
                ->nullOnDelete();
            $table->timestamp('verified_at')->nullable()->after('verified_by');
        });

        DB::statement(
            "ALTER TABLE pembayaran MODIFY COLUMN status "
            . "ENUM('pending', 'awaiting_verification', 'lunas', 'gagal', 'expired') "
            . "NOT NULL DEFAULT 'pending'"
        );
    }

    public function down(): void
    {
        DB::statement(
            "UPDATE pembayaran SET status='gagal' WHERE status='awaiting_verification'"
        );
        DB::statement(
            "ALTER TABLE pembayaran MODIFY COLUMN status "
            . "ENUM('pending', 'lunas', 'gagal', 'expired') "
            . "NOT NULL DEFAULT 'pending'"
        );

        Schema::table('pembayaran', function (Blueprint $table) {
            $table->dropConstrainedForeignId('verified_by');
            $table->dropColumn(['verified_at', 'admin_note', 'bukti_transfer']);
            $table->dropConstrainedForeignId('account_id');
            $table->dropColumn('metode_pembayaran');
        });
    }
};
