<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('candidates', function (Blueprint $table) {
            $table->id();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email')->unique();
            $table->string('phone');
            $table->string('resume_path');
            $table->text('cover_letter')->nullable();
            $table->string('current_company')->nullable();
            $table->string('current_position')->nullable();
            $table->integer('experience_years')->nullable();
            $table->json('education')->nullable();
            $table->json('skills');
            $table->string('linkedin_url')->nullable();
            $table->string('portfolio_url')->nullable();
            $table->string('source');
            $table->string('status');
            $table->text('notes')->nullable();
            $table->foreignId('job_id')->constrained()->onDelete('cascade');
            $table->timestamp('applied_at')->useCurrent();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('candidates');
    }
}; 