<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('documents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->foreignId('department_id')->nullable()->constrained('departments')->nullOnDelete();
            $table->string('title');
            $table->text('description')->nullable();
            $table->string('category', 50)->default('General'); // Policy, Bulletin, Sermon Notes, Constitution, Financial Report, Educational, Form
            $table->string('file_path');
            $table->string('file_name');
            $table->string('file_extension', 10); // pdf, doc, docx
            $table->unsignedBigInteger('file_size_bytes')->default(0);
            $table->string('access_level', 30)->default('members'); // public, members, department, leaders, admin
            $table->foreignId('uploaded_by')->constrained('users');
            $table->unsignedInteger('download_count')->default(0);
            $table->timestamps();

            $table->index(['church_id', 'access_level']);
        });

        Schema::create('youtube_videos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->string('title');
            $table->string('video_url');
            $table->string('youtube_id', 50);
            $table->boolean('is_live')->default(false);
            $table->string('preacher_name')->nullable();
            $table->string('sermon_series')->nullable();
            $table->date('sermon_date')->nullable();
            $table->text('description')->nullable();
            $table->string('thumbnail_url')->nullable();
            $table->foreignId('added_by')->constrained('users');
            $table->timestamps();

            $table->index(['church_id', 'is_live']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('youtube_videos');
        Schema::dropIfExists('documents');
    }
};
