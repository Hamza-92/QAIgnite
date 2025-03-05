<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $fillable = [
        'name',
        'description',
        'deletable',
        'default',
        'organization_id',
        'permissions'
    ];

    protected $casts = [
        'default' => 'boolean',
        'deletable' => 'boolean',
        'permissions' => 'array'
    ];

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function invitations()
    {
        return $this->hasMany(Invitation::class);
    }
}
