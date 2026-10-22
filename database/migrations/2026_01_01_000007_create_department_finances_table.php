<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('department_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->string('type', 20); // 'income', 'expense'
            $table->string('category', 50); // Dues, Fundraiser, Offering, Special Contribution, Refreshment, Equipment, Transport, Welfare
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('USD');
            $table->date('transaction_date');
            $table->string('payment_method', 30)->default('cash');
            $table->string('reference_number', 100)->nullable();
            $table->string('member_name')->nullable(); // Contributor or Payee
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->foreignId('recorded_by')->constrained('users');
            $table->timestamps();

            $table->index(['church_id', 'department_id', 'type']);
            $table->index(['department_id', 'transaction_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('department_finances');
    }
};
