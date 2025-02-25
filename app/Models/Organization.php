<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Organization extends Model
{
    protected $fillable = [
        'name',
        'subdomain',
        'url'
    ];

    public function users() {
        return $this->hasMany(User::class);
    }

    public function roles() {
        return $this->hasMany(Role::class);
    }

}
