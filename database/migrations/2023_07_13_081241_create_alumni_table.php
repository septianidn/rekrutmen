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
        Schema::create('alumni', function (Blueprint $table) {
            $table->bigInteger('nim')->unsigned()->primary();
            $table->string('nama');
            $table->string('email');
            $table->bigInteger('fakultas_prodi_id')->unsigned()->index();
            $table->foreign('fakultas_prodi_id')->references('id')->on('fakultas_prodi')->onDelete('cascade');
            $table->integer('thn_masuk');
            $table->integer('thn_lulus');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
