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
        Schema::create('email_box_ts', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('id_outbox')->unsigned()->index();
            $table->foreign('id_outbox')->references('id')->on('email_box')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('alumni_id')->unsigned()->index();
            $table->foreign('alumni_id')->references('nim')->on('alumni')->onUpdate('cascade')->onDelete('cascade');
            $table->bigInteger('paket_soal_id')->unsigned()->index();
            $table->foreign('paket_soal_id')->references('id')->on('paket_soal')->onUpdate('cascade')->onDelete('cascade');
           
            $table->timestamps();

            
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_box_ts');
    }
};
