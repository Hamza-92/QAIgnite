<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::table('defects', function (Blueprint $table) {
            $table->foreignId('test_case_execution_id')->nullable()->after('def_test_case_id')->constrained('test_case_executions')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::table('defects', function (Blueprint $table) {
            $table->dropForeign(['test_case_execution_id']);
            $table->dropColumn('test_case_execution_id');
        });
    }
};
