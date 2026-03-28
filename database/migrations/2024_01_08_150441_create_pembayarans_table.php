<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::create('pembayaran', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained();
            $table->foreignId('membership_id')->constrained('membership');
            $table->date('tgl_mulai');
            $table->date('tgl_berakhir');
            $table->foreignId('nomor_rekening')->references('nomor_rekening')->on('account')
            ->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {   
        Schema::dropIfExists('pembayaran');
    }
};
