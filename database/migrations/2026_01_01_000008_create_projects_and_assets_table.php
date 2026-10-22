<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->string('title');
            $table->string('project_type', 50)->default('building'); // building, land, renovation, equipment, expansion
            $table->decimal('estimated_cost', 15, 2)->default(0);
            $table->decimal('raised_amount', 15, 2)->default(0);
            $table->decimal('spent_amount', 15, 2)->default(0);
            $table->date('start_date')->nullable();
            $table->date('target_completion_date')->nullable();
            $table->string('status', 30)->default('in_progress'); // planning, in_progress, on_hold, completed
            $table->string('location')->nullable();
            $table->string('leader_name')->nullable();
            $table->text('description')->nullable();
            $table->string('photo_path')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();

            $table->index(['church_id', 'status']);
        });

        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('church_id')->constrained('churches')->cascadeOnDelete();
            $table->foreignId('project_id')->nullable()->constrained('projects')->nullOnDelete();
            $table->string('name');
            $table->string('asset_code', 50);
            $table->string('category', 50); // Land, Building, Vehicle, Audio/Visual, Instrument, Furniture, IT Equipment
            $table->date('purchase_date')->nullable();
            $table->decimal('purchase_price', 15, 2)->nullable();
            $table->decimal('current_value', 15, 2)->nullable();
            $table->string('condition', 30)->default('good'); // new, good, fair, needs_repair, disposed
            $table->string('location')->nullable();
            $table->string('serial_number', 100)->nullable();
            $table->text('warranty_info')->nullable();
            $table->text('maintenance_notes')->nullable();
            $table->timestamps();

            $table->unique(['church_id', 'asset_code']);
            $table->index(['church_id', 'category']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('assets');
        Schema::dropIfExists('projects');
    }
};
