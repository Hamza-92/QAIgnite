<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Attachment extends Model
{
    protected $fillable = [
        'filename',
        'file_type',
        'file_path',
        'project_id',
        'requirement_id'
    ];

    public function project() {
        return $this->belongsTo(Project::class);
    }
}
