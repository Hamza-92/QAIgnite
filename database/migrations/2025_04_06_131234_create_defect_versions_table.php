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
        Schema::create('defect_versions', function (Blueprint $table) {
            $table->id();
            $table->foreignId('defect_id')->constrained('defects')->onDelete('cascade');
            $table->string('def_name');
            $table->string('def_description');
            $table->string('def_status')->default('open');
            $table->string('def_type')->nullable();
            $table->string('def_priority')->default('low');
            $table->string('def_severity')->default('minor');
            $table->string('def_environment')->nullable()->default('production');
            $table->json('def_os')->nullable();
            $table->json('def_browsers')->nullable();
            $table->json('def_devices')->nullable();
            $table->json('def_attachments')->nullable();
            $table->longText('def_steps_to_reproduce')->nullable();
            $table->longText('def_actual_result')->nullable();
            $table->longText('def_expected_result')->nullable();
            $table->foreignId('def_project_id')->constrained('projects')->onDelete('cascade');
            $table->foreignId('def_build_id')->nullable()->constrained('builds')->onDelete('cascade');
            $table->foreignId('def_module_id')->nullable()->constrained('modules')->onDelete('cascade');
            $table->foreignId('def_requirement_id')->nullable()->constrained('requirements')->onDelete('cascade');
            $table->foreignId('def_test_scenario_id')->nullable()->constrained('test_scenarios')->onDelete('cascade');
            $table->foreignId('def_test_case_id')->nullable()->constrained('test_cases')->onDelete('cascade');
            $table->foreignId('def_created_by')->constrained('users')->onDelete('cascade');
            $table->foreignId('def_assigned_to')->nullable()->constrained('users')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('defect_versions');
    }
};
