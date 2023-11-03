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
        Schema::create('pertanyaan_option', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('pertanyaan_id')->unsigned()->index();
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('pertanyaan_option_id')->unsigned()->index();
            $table->foreign('pertanyaan_option_id')->references('id')->on('pertanyaan_general_option')->onUpdate('cascade')->onDelete('cascade');
           
            $table->enum('tipe', ['hide', 'show']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_option');
    }
};
