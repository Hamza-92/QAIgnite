<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('test_scenarios', function (Blueprint $table) {
            $table->id();
            $table->string('ts_name');
            $table->string('ts_description');
            $table->foreignId('ts_project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('ts_build_id')->nullable()->constrained('builds')->cascadeOnDelete();
            $table->foreignId('ts_module_id')->nullable()->constrained('modules')->cascadeOnDelete();
            $table->foreignId('ts_requirement_id')->nullable()->constrained('requirements')->cascadeOnDelete();
            $table->foreignId('ts_created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_scenarios');
    }
};
