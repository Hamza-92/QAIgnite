<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestScenario extends Model
{
    protected $fillable = [
        'ts_name',
        'ts_description',
        'ts_project_id',
        'ts_build_id',
        'ts_module_id',
        'ts_requirement_id',
        'ts_created_by',
    ];


    protected $casts = [
        'ts_project_id' => 'integer',
        'ts_build_id' => 'integer',
        'ts_module_id' => 'integer',
        'ts_requirement_id' => 'integer',
        'ts_created_by' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function build()
    {
        return $this->belongsTo(Build::class, 'ts_build_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'ts_module_id');
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'ts_requirement_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'ts_created_by');
    }

    public function test_cases() {
        return $this->hasMany(TestCase::class, 'tc_test_scenario_id');
    }

    public function defects()
    {
        return $this->hasMany(Defect::class, 'def_test_scenario_id');
    }
}
