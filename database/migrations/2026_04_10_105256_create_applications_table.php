<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('applications', function (Blueprint $table) {
            $table->id();
            $table->foreignId('job_id')->constrained()->cascadeOnDelete();
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
    }

    public function down(): void
    {
        Schema::dropIfExists('applications');
    }
};
