<?php

use App\Livewire\Build\Builds;
use App\Livewire\Defect\DefectDetail;
use App\Livewire\Defect\Defects;
use App\Livewire\Defect\EditDefect;
use App\Livewire\Module\Modules;
use App\Livewire\Project\ArchiveProjects;
use App\Livewire\Project\Projects;
use App\Livewire\Requirement\RequirementDetails;
use App\Livewire\Requirement\Requirements;
use App\Livewire\Role\CreateRole;
use App\Livewire\Role\EditRole;
use App\Livewire\Role\Roles;
use App\Livewire\Settings\Appearance;
use App\Livewire\Settings\Password;
use App\Livewire\Settings\Profile;
use App\Livewire\Team\Team;
use App\Livewire\TestCase\EditTestCase;
use App\Livewire\TestCase\TestCaseDetails;
use App\Livewire\TestCase\TestCases;
use App\Livewire\TestScenario\TestScenarios;
use App\Livewire\TestScenario\TsDetail;
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

    // Project Management
    Route::get('projects', Projects::class)->name('projects');
    Route::get('projects/archive', ArchiveProjects::class)->name('projects.archive');

    // Team Management
    Route::get('/team', Team::class)->name('team');

    // Build Management
    Route::get('/builds', Builds::class)->name('builds');

    // Module Management
    Route::get('/modules', Modules::class)->name('modules');

    // Requriement Management
    Route::get('/requirements', Requirements::class)->name('requirements');
    Route::get('requirements/{requirement_id}/detail', RequirementDetails::class)->name('requirement.detail');

    // Test Scenario Management
    Route::get('/test-scenarios', TestScenarios::class)->name('test-scenarios');
    Route::get('test-scenario/detail/{test_scenario_id}', TsDetail::class)->name('test-scenario.detail');

    // Test Case Management
    Route::get('/test-cases', TestCases::class)->name('test-cases');
    Route::get('test-case/detail/{test_case_id}', TestCaseDetails::class)->name('test-case.detail');
    Route::get('test-case/edit/{test_case_id}', EditTestCase::class)->name('test-case.edit');

    // Defect Management
    Route::get('/defects', Defects::class)->name('defects');
    Route::get('defect/detail/{defect_id}', DefectDetail::class)->name('defect.detail');
    Route::get('defect/edit/{defect_id}', EditDefect::class)->name('defect.edit');
});

Route::middleware(['auth'])->group(function () {
    Route::redirect('settings', 'settings/profile');

    // Route::get('profile', Profile::class)->name('profile');
    // Route::get('profile', Profile::class)->name('settings.profile');
    // Route::get('password', Password::class)->name('settings.password');
    // Route::get('settings/appearance', Appearance::class)->name('settings.appearance');
});

Route::get('invitation/{token}', AcceptInvitation::class)->name('invitation');


require __DIR__.'/auth.php';
