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

        Schema::create('progress', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained('application');
            $table->foreignId('step_id')->constrained('step');
            $table->text('catatan');
            $table->boolean('lulus');
            $table->timestamps();
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('progress');
    }
};
