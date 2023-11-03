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
        Schema::create('pertanyaan_zone', function (Blueprint $table) {
            $table->id();
            
            $table->bigInteger('pertanyaan_id')->unsigned()->index();
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onUpdate('cascade')->onDelete('cascade');
            $table->string('kode_input_provinsi',10);
            $table->string('kode_input_kab_kota',10);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_zone');
    }
};
