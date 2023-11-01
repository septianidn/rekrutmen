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
        Schema::create('email_box', function (Blueprint $table) {
            $table->id();
            $table->string('tujuan');
            $table->string('subjek');
            $table->longText('isi');
            $table->timestamp('tanggal_kirim');
            $table->enum('tipe', ['blasting', 'single', 'None'])->default('single');
          
            $table->enum('status', ['send', 'failed']);
            $table->bigInteger('template_id')->unsigned()->index();
            $table->foreign('template_id')->references('id')->on('email_template')->onUpdate('cascade')->onDelete('cascade');
           
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_box');
    }
};
