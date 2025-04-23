<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('test_plans', function (Blueprint $table) {
            $table->id();
            $table->string('plan_name')->comment('Name of the test plan');
            $table->string('description')->nullable()->comment('Description of the test plan');
            $table->date('start_date')->comment('Start date of the test plan');
            $table->date('end_date')->comment('End date of the test plan');
            $table->longText('milestone')->nullable()->comment('Milestone of the test plan');
            $table->longText('deliverables')->nullable()->comment('Deliverables of the test plan');
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade')->comment('Foreign key to projects table');
            $table->foreignId('build_id')->nullable()->constrained('builds')->nullOnDelete()->comment('Foreign key to builds table');
            $table->foreignId('created_by')->constrained('users')->onDelete('cascade')->comment('Foreign key to users table');
            $table->foreignId('updated_by')->nullable()->constrained('users')->nullOnDelete()->comment('Foreign key to users table');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_plans');
    }
};
