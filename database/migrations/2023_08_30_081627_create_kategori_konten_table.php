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
        Schema::create('kategori_konten', function (Blueprint $table) {
            $table->id();
            $table->string('nama_kategori');
            $table->bigInteger('grup_konten_id')->unsigned()->index();
            $table->foreign('grup_konten_id')->references('id')->on('grup_konten')->onUpdate('cascade')->onDelete('cascade');
            $table->boolean('published');
            $table->longText('deskripsi')->nullable(true);
            $table->string('alias_url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori_konten');
    }
};
