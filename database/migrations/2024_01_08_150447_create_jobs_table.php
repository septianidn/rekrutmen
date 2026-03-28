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
        Schema::disableForeignKeyConstraints();

        Schema::create('job', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employer_id')->constrained('employer');
            $table->string('nama_pekerjaan', 50);
            $table->string('posisi');
            $table->text('requirement');
            //$table->foreignId('posisi_id')->constrained('posisi');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('job');
    }
};
