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
        Schema::create('pertanyaan_general_option', function (Blueprint $table) {
            $table->id();
            $table->string('kode',8);
            $table->bigInteger('pertanyaan_id')->unsigned()->index();
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('urutan')->length(2);
            $table->string('value',50);
            $table->string('label',50);
            $table->string('kode_input_tambahan',8)->nullable();
            $table->enum('tipe', ['single', 'mutiple']);
            $table->timestamps();

            
            $table->unique(['kode', 'pertanyaan_id', 'urutan', 'kode_input_tambahan'], 'unique_pertanyaan_option');
        
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_general_option');
    }
};
