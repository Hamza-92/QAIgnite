<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'avatar',
        'default_project',
        'organization_id',
        'role_id',
        'email_verified_at',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];


    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function organization()
    {
        return $this->belongsTo(Organization::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }

    public function projects() {
        return $this->hasMany(Project::class);
    }

    public function builds() {
        return $this->hasMany(Build::class);
    }

    public function createdRequirements() {
        return $this->hasMany(Requirement::class, 'created_by');
    }

    public function assignedRequirements() {
        return $this->hasMany(Requirement::class, 'assigned_to');
    }
}
