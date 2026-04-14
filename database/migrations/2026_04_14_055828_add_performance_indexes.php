<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // job_postings indexes
        Schema::table('job_postings', function (Blueprint $table) {
            $table->index('status');
            $table->index('company_id');
            $table->index('category_id');
            $table->index('location_type');
            $table->index('type');
            $table->index('published_at');
            $table->index('expires_at');
            $table->index('is_featured');
        });

        // applications indexes
        Schema::table('applications', function (Blueprint $table) {
            $table->index('status');
            $table->index('company_id');
            $table->index('user_id');
            $table->index('job_id');
        });

        // companies indexes
        Schema::table('companies', function (Blueprint $table) {
            $table->index('subscription_status');
            $table->index('is_active');
            $table->index('industry');
        });

        // users indexes
        Schema::table('users', function (Blueprint $table) {
            $table->index('role');
            $table->index('company_id');
            $table->index('is_active');
        });
    }

    public function down(): void
    {
        Schema::table('job_postings', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['company_id']);
            $table->dropIndex(['category_id']);
            $table->dropIndex(['location_type']);
            $table->dropIndex(['type']);
            $table->dropIndex(['published_at']);
            $table->dropIndex(['expires_at']);
            $table->dropIndex(['is_featured']);
        });

        Schema::table('applications', function (Blueprint $table) {
            $table->dropIndex(['status']);
            $table->dropIndex(['company_id']);
            $table->dropIndex(['user_id']);
            $table->dropIndex(['job_id']);
        });

        Schema::table('companies', function (Blueprint $table) {
            $table->dropIndex(['subscription_status']);
            $table->dropIndex(['is_active']);
            $table->dropIndex(['industry']);
        });

        Schema::table('users', function (Blueprint $table) {
            $table->dropIndex(['role']);
            $table->dropIndex(['company_id']);
            $table->dropIndex(['is_active']);
        });
    }
};
