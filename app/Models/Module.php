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
}
