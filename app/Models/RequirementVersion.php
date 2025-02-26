<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RequirementVersion extends Model
{
    protected $fillable = [
        'requirement_id',
        'requirement_title',
        'requirement_summary',
        'requirement_type',
        'requirement_source',
        'status',
        'created_by',
        'project_id',
        'build_id',
        'module_id',
        'parent_requirement_id',
        'assigned_to',
        'attachments',
    ];

    protected $casts = [
        'attachments' => 'array',
    ];

    public function createdBy() {
        return $this->belongsTo(User::class, 'created_by');
    }
    public function project() {
        return $this->belongsTo(Project::class);
    }
    public function build() {
        return $this->belongsTo(Build::class);
    }
    public function module() {
        return $this->belongsTo(Module::class);
    }

    public function parentRequirement() {
        return $this->belongsTo(Requirement::class, 'parent_requirement_id');
    }

    public function childRequirements() {
        return $this->hasMany(Requirement::class, 'parent_requirement_id');
    }

    public function assignedTo() {
        return $this->belongsTo(User::class, 'assigned_to');
    }

    public function comments() {
        return $this->hasMany(Comment::class);
    }

    public function requirement() {
        return $this->belongsTo(Requirement::class);
    }
}
