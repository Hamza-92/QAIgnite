<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'project_id',
        'user_id'
    ];

    public function user() {
        $this->belongsTo('users');
    }

    public function project() {
        $this->belongsTo('projects');
    }
}
