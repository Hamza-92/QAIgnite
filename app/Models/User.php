<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Str;

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

    public function initials(): string
    {
        return Str::of($this->name)
            ->explode(' ')
            ->map(fn (string $name) => Str::of($name)->substr(0, 1))
            ->implode('');
    }

    public function test_scenarios() {
        return $this->hasMany(TestScenario::class, 'ts_created_by');
    }

    public function created_test_cases() {
        return $this->hasMany(TestCase::class, 'tc_created_by');
    }

    public function test_case_approval_requests() {
        return $this->hasMany(TestCase::class, 'tc_approval_request');
    }

    public function assigned_test_cases() {
        return $this->hasMany(TestCase::class, 'tc_assigned_to');
    }

    public function created_defects() {
        return $this->hasMany(Defect::class, 'def_created_by');
    }

    public function assigned_defects() {
        return $this->hasMany(Defect::class, 'def_assigned_to');
    }
}
