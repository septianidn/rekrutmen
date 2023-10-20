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
        Schema::create('pertanyaan_grid_option', function (Blueprint $table) {
            $table->id();
            $table->string('kode',8);
            $table->bigInteger('pertanyaan_id')->unsigned()->index();
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('urutan')->length(2);
            $table->string('value',50);
            $table->string('label',50);
            $table->enum('tipe_grid', ['row', 'column']);
            $table->timestamps();
               
            $table->unique(['kode', 'pertanyaan_id', 'urutan'], 'unique_pertanyaan_grid_option');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_grid_option');
    }
};
