<?php

namespace App\Livewire\Layouts;

use App\Livewire\Actions\Logout;
use App\Models\Project;
use Livewire\Component;

class Header extends Component
{
    public $search = '';
    public $projects;
    public $project;
    public $project_id;
    public $img = '';

    public function mount()
    {
        $this->project = auth()->user()->default_project ? Project::find(auth()->user()->default_project) : null;
        $this->project_id = null;
        $this->projects = Project::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })
            ->where('organization_id', auth()->user()->organization_id)
            ->whereNot('is_archived', true)
            ->orderBy('name', 'ASC')
            ->get(['id', 'name']);
    }

    public function setProject($project_id)
    {
        if (auth()->check() && isset($project_id)) {
            auth()
                ->user()
                ->update(['default_project' => $project_id]);
            $this->redirect(request()->header('Referer'), navigate: true);
        }
    }

    public function updatedSearch()
    {
        $this->refreshList();
    }

    public function refreshList()
    {
        $this->projects = Project::when($this->search, function ($query) {
            $query->where('name', 'like', "%{$this->search}%");
        })
            ->where('organization_id', auth()->user()->organization_id)
            ->where('is_archived', false)
            ->orderBy('name', 'ASC')
            ->get(['id', 'name']);
    }

    public function createProject() {
        session()->put('create_project', true);
        $this->redirect(route('projects'), true);
    }
    public function createBuild() {
        session()->put('create_build', true);
        $this->redirect(route('builds'), true);
    }
    public function createModule() {
        session()->put('create_module', true);
        $this->redirect(route('modules'), true);
    }
    public function createRequirement() {
        session()->put('create_requirement', true);
        $this->redirect(route('requirements'), true);
    }
    public function createTestScenario() {
        session()->put('create_test_scenario', true);
        $this->redirect(route('test-scenarios'), true);
    }
    public function createTestCase() {
        session()->put('create_test_case', true);
        $this->redirect(route('test-cases'), true);
    }
    public function createDefect() {
        session()->put('create_defect', true);
        $this->redirect(route('defects'), true);
    }
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
    public function render()
    {
        return view('livewire.layouts.header');
    }
}
