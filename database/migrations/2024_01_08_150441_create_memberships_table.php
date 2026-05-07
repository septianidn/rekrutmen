<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('membership', function (Blueprint $table) {
            $table->id();
            $table->string('nama_membership', 50);
            $table->decimal('harga', 10, 2);
            $table->unsignedInteger('durasi_hari')->default(365);
            $table->boolean('can_post_job')->default(false);
            $table->boolean('can_post_article')->default(false);
            $table->text('deskripsi')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('membership');
    }
};
