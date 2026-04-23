<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('jobseeker', function (Blueprint $table) {
            $table->string('jenis_kelamin', 15)->nullable()->change();
            $table->date('ttl')->nullable()->change();
        });
    }

    public function down(): void
    {
        Schema::table('jobseeker', function (Blueprint $table) {
            $table->string('jenis_kelamin', 15)->nullable(false)->change();
            $table->date('ttl')->nullable(false)->change();
        });
    }
};
