<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Build extends Model
{
    protected $fillable = [
        'name',
        'description',
        'start_date',
        'end_date',
        'project_id',
        'user_id'
    ];

    protected $casts = [
        'created_at' => 'date:d-m-Y',
        'start_date' => 'date',
        'end_date' => 'date',
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function modules() {
        return $this->hasMany(Module::class);
    }

    public function requirements() {
        return $this->hasMany(Requirement::class);
    }

    public function test_scenarios() {
        return $this->hasMany(TestScenario::class);
    }
}
