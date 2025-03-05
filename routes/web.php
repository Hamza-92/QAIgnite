<?php

use App\Livewire\Project\ArchiveProjects;
use App\Livewire\Project\Projects;
use App\Livewire\Role\CreateRole;
use App\Livewire\Role\EditRole;
use App\Livewire\Role\Roles;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\User\AcceptInvitation;
use App\Livewire\User\Users;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::middleware(['auth', 'verified'])->group(function () {
    Route::view('dashboard', 'dashboard')->name('dashboard');

    // User Management
    Route::get('users', Users::class)->name('users');

    // Role Management
    Route::get('roles', Roles::class)->name('roles');
    Route::get('roles/create', CreateRole::class)->name('role.create');
    Route::get('roles/{id}/edit', EditRole::class)->name('role.edit');

    // // Project Management
    Route::get('projects', Projects::class)->name('projects');
    Route::get('projects/archive', ArchiveProjects::class)->name('projects.archive');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    Route::get('profile', Profile::class)->name('profile');
    Route::get('password', Password::class)->name('profile.password');
    Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('invitation/{token}', AcceptInvitation::class)->name('invitation');


require __DIR__.'/auth.php';
