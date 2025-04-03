<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('test_cases', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('description');
            $table->string('status');
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('build_id')->nullable()->constrained('builds')->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained('modules')->cascadeOnDelete();
            $table->foreignId('requirement_id')->nullable()->constrained('requirements')->cascadeOnDelete();
            $table->foreignId('test_scenario_id')->nullable()->constrained('test_scenarios')->cascadeOnDelete();
            $table->string('testing_type')->nullable();
            $table->time('estimated_time')->nullable();
            $table->longText('preconditions')->nullable();
            $table->longText('detailed_steps')->nullable();
            $table->longText('expected_results')->nullable();
            $table->longText('post_conditions')->nullable();
            $table->string('execution_type')->nullable();
            $table->string('priority')->nullable();
            $table->string('task_board')->nullable();
            $table->json('attachments')->nullable();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('approval_request')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('assigned_to')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_cases');
    }
};
