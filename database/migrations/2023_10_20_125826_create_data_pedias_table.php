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
        Schema::create('data_pedias', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('value');
            $table->string('label');
            $table->bigInteger('parent_id')->unsigned()->index()->nullable()->default(null);;
            $table->foreign('parent_id')->references('id')->on('data_pedias')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_pedias');
    }
};
