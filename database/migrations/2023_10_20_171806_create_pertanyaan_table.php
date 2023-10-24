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
        Schema::create('pertanyaan', function (Blueprint $table) {
            $table->id();
            $table->string('kode_soal',15);
            $table->bigInteger('halaman_id')->unsigned()->index();
            $table->foreign('halaman_id')->references('id')->on('halaman_pertanyaan')->onUpdate('cascade')->onDelete('cascade');
            $table->smallInteger('urutan')->length(2);
            $table->text('pertanyaan');
            $table->enum('tipe_pertanyaan', ['general', 'general_option', 'grid_option', 'dropdown', 'zone']);
            $table->boolean('wajib_dijawab')->default('1');
            $table->timestamps();

            $table->unique(['kode_soal', 'halaman_id', 'urutan']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan');
    }
};
