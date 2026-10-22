<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('financial_transactions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->string('transaction_code', 50)->unique();
            $table->foreignId('member_id')->nullable()->constrained('members')->nullOnDelete();
            $table->string('donor_name')->nullable(); // For visitors / anonymous donors
            $table->foreignId('service_id')->nullable()->constrained('services')->nullOnDelete();
            $table->string('category', 50); // tithe, regular_offering, thanksgiving, building_offering, special_contribution, other_income
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('USD');
            $table->string('payment_method', 30)->default('cash'); // cash, bank_transfer, mobile_money, cheque, card
            $table->string('reference_number', 100)->nullable();
            $table->date('transaction_date');
            $table->text('notes')->nullable();
            $table->string('status', 20)->default('pending'); // pending, confirmed, rejected, reversed
            $table->foreignId('entered_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->text('rejection_reason')->nullable();
            $table->foreignId('reversed_by')->nullable()->constrained('users');
            $table->timestamp('reversed_at')->nullable();
            $table->text('reversal_reason')->nullable();
            $table->timestamps();

            $table->index(['church_id', 'status', 'category']);
            $table->index(['church_id', 'transaction_date']);
        });

        Schema::create('expenses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->string('expense_code', 50)->unique();
            $table->string('title');
            $table->string('category', 50); // Utilities, Honorarium, Welfare, Missions, Maintenance, Administration, Equipment, Media, Outreach
            $table->decimal('amount', 15, 2);
            $table->string('currency', 10)->default('USD');
            $table->date('expense_date');
            $table->string('payment_method', 30)->default('cash');
            $table->string('recipient_name')->nullable();
            $table->text('description')->nullable();
            $table->string('receipt_path')->nullable();
            $table->string('status', 20)->default('pending'); // pending, approved, paid, rejected
            $table->foreignId('entered_by')->constrained('users');
            $table->foreignId('approved_by')->nullable()->constrained('users');
            $table->timestamp('approved_at')->nullable();
            $table->timestamps();

            $table->index(['church_id', 'status', 'expense_date']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('expenses');
        Schema::dropIfExists('financial_transactions');
    }
};
