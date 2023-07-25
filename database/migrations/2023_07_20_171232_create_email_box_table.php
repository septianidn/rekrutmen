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
        Schema::create('email_box', function (Blueprint $table) {
            $table->id();
            $table->string('tujuan');
            $table->string('subjek');
            $table->string('isi');
            $table->timestamp('tanggal_kirim');
            $table->string('tipe');
            $table->string('status');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_box');
    }
};
