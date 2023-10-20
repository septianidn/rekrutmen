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
        Schema::create('pertanyaan_general', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pertanyaan_id')->unsigned()->index();
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onUpdate('cascade')->onDelete('cascade');
            $table->enum('tipe_pertanyaan_general', ['short_answer', 'paragraph', 'date', 'time', 'email','number']);
            $table->integer('max_character_jawaban')->length(3)->nullable();   
            $table->integer('min_character_jawaban')->length(1)->nullable();
            $table->timestamps();

            $table->unique(['pertanyaan_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_general');
    }
};
