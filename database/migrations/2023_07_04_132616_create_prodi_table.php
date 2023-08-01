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
        Schema::create('prodi', function (Blueprint $table) {
            $table->bigInteger('kode_prodi')->unsigned()->primary();
            $table->string('nama_prodi');
            $table->bigInteger('jenjang_id')->unsigned()->index();
            $table->foreign('jenjang_id')->references('id')->on('jenjang')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('fakultas_id')->unsigned()->index();
            $table->foreign('fakultas_id')->references('id')->on('fakultas')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('prodi');
    }
};
