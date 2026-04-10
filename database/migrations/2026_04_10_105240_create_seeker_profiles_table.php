<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('seeker_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->string('headline')->nullable();
            $table->text('summary')->nullable();
            $table->string('location')->nullable();
            $table->unsignedInteger('experience_years')->default(0);
            $table->unsignedInteger('current_salary')->nullable();
            $table->unsignedInteger('expected_salary')->nullable();
            $table->unsignedInteger('notice_period_days')->default(30);
            $table->string('resume_path')->nullable();
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('github_url')->nullable();
            $table->json('skills')->nullable();
            $table->json('languages')->nullable();
            $table->enum('availability', ['immediate','1_month','3_months','not_looking'])
                  ->default('immediate');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('seeker_profiles');
    }
};
