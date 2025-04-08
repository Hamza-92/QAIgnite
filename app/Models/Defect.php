<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Defect extends Model
{
    protected $fillable = [
        'def_name',
        'def_description',
        'def_status',
        'def_type',
        'def_priority',
        'def_severity',
        'def_environment',
        // 'def_os',
        // 'def_browsers',
        // 'def_devices',
        'def_attachments',
        'def_steps_to_reproduce',
        'def_actual_result',
        'def_expected_result',
        'def_project_id',
        'def_build_id',
        'def_module_id',
        'def_requirement_id',
        'def_test_scenario_id',
        'def_test_case_id',
        'def_created_by',
        'def_assigned_to',
    ];

    protected $casts = [
        'def_attachments' => 'array',

        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];
    public function project()
    {
        return $this->belongsTo(Project::class, 'def_project_id');
    }
    public function build()
    {
        return $this->belongsTo(Build::class, 'def_build_id');
    }
    public function module()
    {
        return $this->belongsTo(Module::class, 'def_module_id');
    }
    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'def_requirement_id');
    }
    public function testScenario()
    {
        return $this->belongsTo(TestScenario::class, 'def_test_scenario_id');
    }
    public function testCase()
    {
        return $this->belongsTo(TestCase::class, 'def_test_case_id');
    }
    public function createdBy()
    {
        return $this->belongsTo(User::class, 'def_created_by');
    }
    public function assignedTo()
    {
        return $this->belongsTo(User::class, 'def_assigned_to');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class, 'defect_id');
    }
    public function history()
    {
        return $this->hasMany(DefectVersion::class, 'defect_id');
    }
}
