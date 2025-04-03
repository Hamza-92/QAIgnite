<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TestScenario extends Model
{
    protected $fillable = [
        'name',
        'description',
        'project_id',
        'build_id',
        'module_id',
        'requirement_id',
        'created_by',
    ];


    protected $casts = [
        'project_id' => 'integer',
        'build_id' => 'integer',
        'module_id' => 'integer',
        'requirement_id' => 'integer',
        'created_by' => 'integer',
    ];

    public function project()
    {
        return $this->belongsTo(Project::class);
    }

    public function build()
    {
        return $this->belongsTo(Build::class, 'build_id');
    }

    public function module()
    {
        return $this->belongsTo(Module::class, 'module_id');
    }

    public function requirement()
    {
        return $this->belongsTo(Requirement::class, 'requirement_id');
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
