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
        Schema::create('data_pedia_detail', function (Blueprint $table) {
            $table->id();
            $table->bigInteger('data_pedia_id')->unsigned()->index();
            $table->foreign('data_pedia_id')->references('id')->on('data_pedia')->onUpdate('cascade')->onDelete('cascade');
            $table->string('value');
            $table->string('label');
            $table->boolean('publish');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pedia_detail');
    }
};
