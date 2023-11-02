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
            $table->bigInteger('kode_prodi_id')->unsigned()->index();
            $table->foreign('kode_prodi_id')->references('kode_prodi')->on('prodi')->onUpdate('cascade')->onDelete('cascade');
            $table->integer('thn_masuk');
            $table->integer('thn_lulus');
            $table->string('tempat_lahir')->nullable(true);
            $table->date('tanggal_lahir')->nullable(true);
            $table->string('nomor_handphone')->unique()->nullable(true);
            $table->string('pin', 8)->unique()->nullable(true);
            $table->string('nik', 16)->unique()->nullable(true);
            $table->string('npwp', 25)->unique()->nullable(true);
            $table->text('judul_tesis')->nullable(true);; 
            $table->enum('periode_wisuda', ['Wisuda I', 'Wisuda II', 'Wisuda III', 'Wisuda IV', 'Wisuda V', 'Wisuda VI'])->nullable(true);;
            $table->enum('status_tc', ['Complete', 'Pending', 'None'])->default('None');
            $table->rememberToken();
           
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
