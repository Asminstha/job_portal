<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::disableForeignKeyConstraints();

        // ── Job Postings ───────────────────────────────────────
        Schema::create('job_postings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()
                  ->constrained('job_categories')->nullOnDelete();
            $table->string('title');
            $table->string('slug')->unique();
            $table->longText('description');
            $table->text('requirements')->nullable();
            $table->text('benefits')->nullable();
            $table->enum('type', ['full_time','part_time','contract','internship','freelance'])
                  ->default('full_time');
            $table->enum('location_type', ['remote','onsite','hybrid'])->default('onsite');
            $table->string('city')->nullable();
            $table->string('country')->default('Nepal');
            $table->unsignedInteger('salary_min')->nullable();
            $table->unsignedInteger('salary_max')->nullable();
            $table->string('salary_currency')->default('NPR');
            $table->enum('salary_period', ['monthly','yearly','hourly'])->default('monthly');
            $table->boolean('salary_hidden')->default(false);
            $table->unsignedTinyInteger('experience_min')->default(0);
            $table->unsignedTinyInteger('experience_max')->nullable();
            $table->enum('status', ['draft','active','paused','closed','expired'])
                  ->default('draft');
            $table->boolean('is_featured')->default(false);
            $table->timestamp('featured_until')->nullable();
            $table->unsignedInteger('applications_count')->default(0);
            $table->unsignedInteger('views_count')->default(0);
            $table->timestamp('expires_at')->nullable();
            $table->timestamp('published_at')->nullable();
            $table->timestamps();
        });

        // ── Applications ───────────────────────────────────────
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->text('cover_letter')->nullable();
            $table->string('resume_path')->nullable();
            $table->enum('status', [
                'pending','reviewed','shortlisted',
                'interview','offered','hired','rejected','withdrawn'
            ])->default('pending');
            $table->timestamp('status_changed_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->text('notes')->nullable();
            $table->timestamp('read_at')->nullable();
            $table->timestamps();
            $table->unique(['job_id','user_id']);
        });

        // ── Application Status History ─────────────────────────
        Schema::create('application_status_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('changed_by')->constrained('users')->cascadeOnDelete();
            $table->string('from_status')->nullable();
            $table->string('to_status');
            $table->text('note')->nullable();
            $table->timestamp('created_at')->useCurrent();
        });

        // ── Interviews ─────────────────────────────────────────
        Schema::create('interviews', function (Blueprint $table) {
            $table->id();
            $table->foreignId('application_id')->constrained()->cascadeOnDelete();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('scheduled_by')->constrained('users')->cascadeOnDelete();
            $table->enum('interview_type', ['phone','video','onsite','technical'])
                  ->default('video');
            $table->timestamp('scheduled_at');
            $table->unsignedInteger('duration_minutes')->default(60);
            $table->string('location_or_link')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status', ['scheduled','completed','cancelled','rescheduled'])
                  ->default('scheduled');
            $table->timestamps();
        });

        // ── Saved Jobs ─────────────────────────────────────────
        Schema::create('saved_jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->foreignId('job_id')->constrained('job_postings')->cascadeOnDelete();
            $table->timestamp('created_at')->useCurrent();
            $table->unique(['user_id','job_id']);
        });

        // ── Job Views ──────────────────────────────────────────
        Schema::create('job_views', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained('job_postings')->cascadeOnDelete();
            $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete();
            $table->string('ip_address', 45)->nullable();
            $table->timestamp('viewed_at')->useCurrent();
        });

        Schema::enableForeignKeyConstraints();
    }

    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('job_views');
        Schema::dropIfExists('saved_jobs');
        Schema::dropIfExists('interviews');
        Schema::dropIfExists('application_status_histories');
        Schema::dropIfExists('applications');
        Schema::dropIfExists('job_postings');
        Schema::enableForeignKeyConstraints();
    }
};
