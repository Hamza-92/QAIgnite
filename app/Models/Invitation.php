<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Invitation extends Model
{
    protected $fillable = [
        'name',
        'email',
        'organization_id',
        'role_id',
        'token',
        'expires_at'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
