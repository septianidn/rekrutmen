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
        Schema::create('pertanyaan_dropdown', function (Blueprint $table) {
            $table->id();
        
            $table->bigInteger('pertanyaan_id')->unsigned()->index();
            $table->foreign('pertanyaan_id')->references('id')->on('pertanyaan')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('data_pedia_id')->unsigned()->index();
            $table->foreign('data_pedia_id')->references('id')->on('data_pedia')->onUpdate('cascade')->onDelete('cascade');
            $table->string('placeholder')->nullable();
            $table->timestamps();

            $table->unique(['pertanyaan_id', 'data_pedia_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pertanyaan_dropdown');
    }
};
