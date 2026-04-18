<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // Fix applications table
        Schema::table('applications', function (Blueprint $table) {
            // Drop wrong foreign key
            try { $table->dropForeign(['job_id']); } catch (\Exception $e) {}
            // Add correct one
            $table->foreign('job_id')
                  ->references('id')
                  ->on('job_postings')
                  ->cascadeOnDelete();
        });

        // Fix saved_jobs table
        Schema::table('saved_jobs', function (Blueprint $table) {
            try { $table->dropForeign(['job_id']); } catch (\Exception $e) {}
            $table->foreign('job_id')
                  ->references('id')
                  ->on('job_postings')
                  ->cascadeOnDelete();
        });

        // Fix job_views table
        Schema::table('job_views', function (Blueprint $table) {
            try { $table->dropForeign(['job_id']); } catch (\Exception $e) {}
            $table->foreign('job_id')
                  ->references('id')
                  ->on('job_postings')
                  ->cascadeOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::table('applications', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->foreign('job_id')->references('id')->on('jobs')->cascadeOnDelete();
        });

        Schema::table('saved_jobs', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->foreign('job_id')->references('id')->on('jobs')->cascadeOnDelete();
        });

        Schema::table('job_views', function (Blueprint $table) {
            $table->dropForeign(['job_id']);
            $table->foreign('job_id')->references('id')->on('jobs')->cascadeOnDelete();
        });

        Schema::enableForeignKeyConstraints();
    }
};
