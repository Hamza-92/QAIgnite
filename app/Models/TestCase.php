<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestCase extends Model
{
    protected $fillable = [
        'tc_name',
        'tc_description',
        'tc_status',
        'tc_project_id',
        'tc_build_id',
        'tc_module_id',
        'tc_requirement_id',
        'tc_test_scenario_id',
        'tc_testing_type',
        'tc_estimated_time',
        'tc_preconditions',
        'tc_detailed_steps',
        'tc_expected_results',
        'tc_post_conditions',
        'tc_execution_type',
        'tc_priority',
        'tc_task_board',
        'tc_attachments',
        'tc_created_by',
        'tc_approval_request',
        'tc_assigned_to',
    ];

    protected $casts = [
        'tc_attachments' => 'array',
        'tc_project_id' => 'integer',
        'tc_build_id' => 'integer',
        'tc_module_id' => 'integer',
        'tc_requirement_id' => 'integer',
        'tc_test_scenario_id' => 'integer',
        'tc_created_by' => 'integer',
        'tc_assigned_to' => 'integer',
        'tc_approval_request' => 'integer',
        'tc_estimated_time' => 'integer',
    ];

    public function project() {
        return $this->belongsTo(Project::class, 'tc_project_id');
    }
    public function build() {
        return $this->belongsTo(Build::class, 'tc_build_id');
    }
    public function module() {
        return $this->belongsTo(Module::class, 'tc_module_id');
    }
    public function requirement() {
        return $this->belongsTo(Requirement::class, 'tc_requirement_id');
    }
    public function test_scenario() {
        return $this->belongsTo(TestScenario::class, 'tc_test_scenario_id');
    }
    public function created_by() {
        return $this->belongsTo(User::class, 'tc_created_by');
    }
    public function assigned_to() {
        return $this->belongsTo(User::class, 'tc_assigned_to');
    }
    public function approval_request() {
        return $this->belongsTo(User::class, 'tc_approval_request');
    }
    public function comments() {
        return $this->hasMany(Comment::class, 'test_case_id');
    }
    public function test_case_versions() {
        return $this->hasMany(TestCaseVersion::class, 'test_case_id');
    }

    public function defects() {
        return $this->hasMany(Defect::class, 'def_test_case_id');
    }
}
