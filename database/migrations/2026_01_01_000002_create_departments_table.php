<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('departments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->string('name');
            $table->string('slug');
            $table->text('description')->nullable();
            $table->string('leader_name')->nullable();
            $table->string('leader_phone')->nullable();
            $table->string('meeting_day')->nullable();
            $table->string('meeting_time')->nullable();
            $table->string('banner_color', 20)->default('#4f46e5');
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['church_id', 'slug']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('departments');
    }
};
