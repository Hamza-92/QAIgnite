<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    protected $fillable = [
        'module_name',
        'module_description',
        'build_id',
        'project_id'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function build() {
        return $this->belongsTo(Build::class);
    }

    public function requirements() {
        return $this->hasMany(Requirement::class);
    }

    public function test_scenarios() {
        return $this->hasMany(TestScenario::class, 'ts_module_id');
    }

    public function test_cases() {
        return $this->hasMany(TestCase::class, 'tc_module_id');
    }

    public function defects() {
        return $this->hasMany(Defect::class, 'def_module_id');
    }
}
