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
        Schema::create('fakultas_prodi', function (Blueprint $table) {
            $table->id();
          
            $table->bigInteger('prodi_id')->unsigned()->index();
            $table->foreign('prodi_id')->references('kode_prodi')->on('prodi')->onDelete('cascade');
            $table->bigInteger('fakultas_id')->unsigned()->index();
            $table->foreign('fakultas_id')->references('id')->on('fakultas')->onDelete('cascade');
            $table->bigInteger('jenjang_id')->unsigned()->index();
            $table->foreign('jenjang_id')->references('id')->on('jenjang')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fakultas_prodi');
    }
};
