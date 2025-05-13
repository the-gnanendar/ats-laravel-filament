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
            $table->string('title');
            $table->text('description');
            $table->text('requirements');
            $table->string('location');
            $table->string('type');
            $table->string('status');
            $table->string('department');
            $table->string('experience_level');
            $table->string('salary_range');
            $table->foreignId('posted_by')->constrained('users');
            $table->foreignId('company_id')->nullable()->constrained('companies');
            $table->timestamp('application_deadline');
            $table->boolean('is_remote')->default(false);
            $table->json('benefits')->nullable();
            $table->json('skills_required')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
}; 