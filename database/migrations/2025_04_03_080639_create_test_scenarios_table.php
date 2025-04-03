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
            $table->string('name');
            $table->string('description');
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('build_id')->nullable()->constrained('builds')->cascadeOnDelete();
            $table->foreignId('module_id')->nullable()->constrained('modules')->cascadeOnDelete();
            $table->foreignId('requirement_id')->nullable()->constrained('requirements')->cascadeOnDelete();
            $table->foreignId('created_by')->constrained('users')->cascadeOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('test_scenarios');
    }
};
