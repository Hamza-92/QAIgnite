<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Team extends Model
{
    protected $fillable = [
        'project_id',
        'user_id'
    ];

    public function members() {
        $this->belongsToMany('users');
    }
}
