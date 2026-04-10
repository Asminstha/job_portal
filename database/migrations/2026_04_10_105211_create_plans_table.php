<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->text('description')->nullable();
            $table->unsignedInteger('price_monthly')->default(0);
            $table->unsignedInteger('price_yearly')->default(0);
            $table->unsignedInteger('max_jobs')->nullable();
            $table->unsignedInteger('max_recruiters')->default(1);
            $table->boolean('featured_jobs_allowed')->default(false);
            $table->boolean('has_analytics')->default(false);
            $table->boolean('has_ats')->default(true);
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};
