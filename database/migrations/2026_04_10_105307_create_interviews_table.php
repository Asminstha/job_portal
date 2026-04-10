<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
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
    }

    public function down(): void
    {
        Schema::dropIfExists('interviews');
    }
};
