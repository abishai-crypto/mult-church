<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('prayer_requests', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('requester_name', 100);
            $table->string('requester_phone', 30)->nullable();
            $table->string('category', 50)->default('General'); // Healing, Family, Deliverance, Financial, Spiritual, Thanksgiving
            $table->text('request_text');
            $table->boolean('is_confidential')->default(false); // If true, only pastor and elders can see!
            $table->string('status', 20)->default('pending'); // pending, praying, answered
            $table->text('pastoral_notes')->nullable(); // pastoral confidential notes
            $table->text('testimony')->nullable();
            $table->timestamps();

            $table->index(['church_id', 'is_confidential', 'status']);
        });

        Schema::create('pastoral_visits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->foreignId('pastor_id')->constrained('users')->cascadeOnDelete();
            $table->date('visit_date');
            $table->string('visit_type', 50)->default('Home Visit'); // Home Visit, Hospital Visit, Counseling, Bereavement, Phone Call
            $table->text('notes')->nullable();
            $table->boolean('follow_up_required')->default(false);
            $table->date('follow_up_date')->nullable();
            $table->timestamps();

            $table->index(['church_id', 'visit_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('pastoral_visits');
        Schema::dropIfExists('prayer_requests');
    }
};
