<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->string('member_number', 50)->nullable();
            $table->string('first_name', 100);
            $table->string('last_name', 100);
            $table->string('gender', 20)->nullable(); // Male, Female
            $table->date('date_of_birth')->nullable();
            $table->string('marital_status', 30)->nullable(); // Single, Married, Widowed, Divorced
            $table->string('phone', 30)->nullable();
            $table->string('email', 100)->nullable();
            $table->text('residential_address')->nullable();
            $table->string('occupation', 100)->nullable();
            $table->string('baptism_status', 30)->default('Not Baptized'); // Baptized, Not Baptized
            $table->date('baptism_date')->nullable();
            $table->string('membership_status', 30)->default('Active'); // Active, Inactive, Transferred, Deceased
            $table->date('joined_date')->nullable();
            $table->string('emergency_contact_name', 100)->nullable();
            $table->string('emergency_contact_phone', 30)->nullable();
            $table->string('photo_path')->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index(['church_id', 'membership_status']);
        });

        Schema::create('department_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->foreignId('member_id')->constrained('members')->cascadeOnDelete();
            $table->string('role_in_department', 50)->default('Member'); // Member, Chairperson, Vice Chair, Secretary, Treasurer
            $table->date('joined_at')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->unique(['department_id', 'member_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_members');
        Schema::dropIfExists('members');
    }
};
