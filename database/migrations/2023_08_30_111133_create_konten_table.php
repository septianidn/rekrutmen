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
        Schema::create('konten', function (Blueprint $table) {
            $table->id();
            $table->string('judul');
            $table->bigInteger('kategori_konten_id')->unsigned()->index();
            $table->foreign('kategori_konten_id')->references('id')->on('kategori_konten')->onUpdate('cascade')->onDelete('cascade');
            $table->longText('isi_konten');
            $table->string('alias_url');
            $table->dateTime('waktu_terbit')->nullable(true);
            $table->dateTime('waktu_tutup')->nullable(true);
            $table->string('tags')->nullable(true);
            $table->string('gambar_headline')->nullable(true);
            $table->string('meta_key')->nullable(true);
            $table->string('meta_desc')->nullable(true);
            $table->boolean('published')->default(false);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konten');
    }
};
