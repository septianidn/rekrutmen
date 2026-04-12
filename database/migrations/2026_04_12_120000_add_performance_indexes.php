<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // application: queried by job_id + status on every employer dashboard
        Schema::table('application', function (Blueprint $table) {
            $table->index(['job_id', 'status']);
            $table->index('jobseeker_id');
        });

        // job: queried by employer_id on every employer page
        Schema::table('job', function (Blueprint $table) {
            $table->index('employer_id');
        });

        // step: loaded by job_id when viewing job details / applicant progress
        Schema::table('step', function (Blueprint $table) {
            $table->index('job_id');
        });

        // progress: queried by application_id and step_id for pipeline tracking
        Schema::table('progress', function (Blueprint $table) {
            $table->index('application_id');
            $table->index('step_id');
        });

        // jobseeker: resolved via user_id on every jobseeker page (Auth::user()->jobseeker)
        Schema::table('jobseeker', function (Blueprint $table) {
            $table->index('user_id');
        });
    }

    public function down(): void
    {
        Schema::table('application', function (Blueprint $table) {
            $table->dropIndex(['job_id', 'status']);
            $table->dropIndex(['jobseeker_id']);
        });

        Schema::table('job', function (Blueprint $table) {
            $table->dropIndex(['employer_id']);
        });

        Schema::table('step', function (Blueprint $table) {
            $table->dropIndex(['job_id']);
        });

        Schema::table('progress', function (Blueprint $table) {
            $table->dropIndex(['application_id']);
            $table->dropIndex(['step_id']);
        });

        Schema::table('jobseeker', function (Blueprint $table) {
            $table->dropIndex(['user_id']);
        });
    }
};
