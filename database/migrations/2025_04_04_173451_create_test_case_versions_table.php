<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('test_case_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('test_case_id')->constrained('test_cases')->cascadeOnDelete();
            $table->string('tc_name');
            $table->string('tc_description');
            $table->string('tc_status');
            $table->foreignId('tc_project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('tc_build_id')->nullable()->constrained('builds')->cascadeOnDelete();
            $table->foreignId('tc_module_id')->nullable()->constrained('modules')->cascadeOnDelete();
            $table->foreignId('tc_requirement_id')->nullable()->constrained('requirements')->cascadeOnDelete();
            $table->foreignId('tc_test_scenario_id')->nullable()->constrained('test_scenarios')->cascadeOnDelete();
            $table->string('tc_testing_type')->nullable();
            $table->time('tc_estimated_time')->nullable();
            $table->longText('tc_preconditions')->nullable();
            $table->longText('tc_detailed_steps')->nullable();
            $table->longText('tc_expected_results')->nullable();
            $table->longText('tc_post_conditions')->nullable();
            $table->string('tc_execution_type')->nullable();
            $table->string('tc_priority')->nullable()->default('low');
            $table->string('tc_task_board')->nullable();
            $table->json('tc_attachments')->nullable();
            $table->foreignId('tc_created_by')->constrained('users')->cascadeOnDelete();
            $table->foreignId('tc_approval_request')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('tc_assigned_to')->nullable()->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('test_case_versions');
    }
};
