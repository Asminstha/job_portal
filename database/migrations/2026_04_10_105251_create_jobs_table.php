<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('category_id')->nullable()->constrained('job_categories')
                  ->nullOnDelete();
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
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};
