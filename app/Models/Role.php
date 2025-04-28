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
    ];

    protected $casts = [
        'default' => 'boolean',
        'deletable' => 'boolean',
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

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function hasPermission($permissionSlug)
    {
        return $this->permissions()->where('slug', $permissionSlug)->exists();
    }
}
