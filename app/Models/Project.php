<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'description',
        'status',
        'type',
        'os',
        'devices',
        'browsers',
        'is_archived',
        'user_id',
        'organization_id',
    ];

    protected $casts = [
        'is_archived' => 'boolean',
        'type' => 'array',
        'os' => 'array',
        'devices' => 'array',
        'browsers' => 'array',
        'created_at' => 'datetime:d-m-Y H:i:s',
        'updated_at' => 'datetime:d-m-Y H:i:s',
    ];

    public function organization() {
        return $this->belongsTo(Organization::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function team() {
        return $this->hasMany(Team::class);
    }

    public function builds() {
        return $this->hasMany(Build::class);
    }

    public function modules() {
        return $this->hasMany(Module::class);
    }

    public function requirements() {
        return $this->hasMany(Requirement::class);
    }

    public function test_scenarios() {
        return $this->hasMany(TestScenario::class, 'ts_project_id');
    }

    public function test_cases() {
        return $this->hasMany(TestCase::class, 'tc_project_id');
    }

    public function defects() {
        return $this->hasMany(Defect::class, 'def_project_id');
    }

}
