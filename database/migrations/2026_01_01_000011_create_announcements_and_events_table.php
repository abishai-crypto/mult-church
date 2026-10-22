<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('announcements', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('title');
            $table->text('content');
            $table->string('priority', 20)->default('normal'); // normal, high, urgent
            $table->string('audience', 30)->default('all'); // all, members, leaders, department
            $table->date('publish_date')->nullable();
            $table->date('expires_at')->nullable();
            $table->boolean('is_pinned')->default(false);
            $table->foreignId('posted_by')->constrained('users');
            $table->timestamps();

            $table->index(['church_id', 'is_pinned']);
        });

        Schema::create('events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->dateTime('start_time');
            $table->dateTime('end_time')->nullable();
            $table->string('color', 20)->default('#2563eb');
            $table->string('banner_path')->nullable();
            $table->boolean('is_public')->default(true);
            $table->foreignId('created_by')->constrained('users');
            $table->timestamps();

            $table->index(['church_id', 'start_time']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('events');
        Schema::dropIfExists('announcements');
    }
};
