<?php

use App\Livewire\Pages\Project\ArchiveProjects;
use App\Livewire\Pages\Project\Projects;
use App\Livewire\Pages\Role\CreateRole;
use App\Livewire\Pages\Role\Roles;
use App\Livewire\Pages\User\AcceptInvitation;
use App\Livewire\Pages\User\CreateUser;
use App\Livewire\Pages\User\Users;
use Illuminate\Support\Facades\Route;

Route::view('/', 'welcome');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // User Management
    Route::get('users', Users::class)->name('users');

    // Role Management
    Route::get('roles', Roles::class)->name('roles');
    Route::get('roles/create', CreateRole::class)->name('create-role');

    // Project Management
    Route::get('projects', Projects::class)->name('projects');
    Route::get('projects/archive', ArchiveProjects::class)->name('projects.archive');
});


Route::view('profile', 'profile')
    ->middleware(['auth'])
    ->name('profile');

Route::get('invitation/{token}', AcceptInvitation::class)->name('invitation');

require __DIR__ . '/auth.php';
