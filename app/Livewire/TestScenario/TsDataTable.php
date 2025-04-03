<?php

namespace App\Livewire\TestScenario;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestScenario;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class TsDataTable extends Component
{
    use WithPagination;

    // Table attributes
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $perPage = 20;


    // Filter: build field data halndling
    public $builds;
    public $build_id;

    // Filter: module field data halndling
    public $modules;
    public $module_id;

    // Filter: module field data halndling
    public $requirements;
    public $requirement_id;

    // Filter: created_by field data handling
    public $users;
    public $created_by;

    public function mount()
    {
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->created_by = null;

        // Fetch users who have created test scenarios in the project
        $this->users = User::whereHas('test_scenarios', function ($query) {
            $query->where('project_id', auth()->user()->default_project);
        })
        ->select('id', 'name')
        ->distinct()
        ->get();



        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
    }

    public function updatedBuildId()
    {
        $this->updateModulesList();
        $this->updateRequirementsList();
    }

    public function updatedModuleId()
    {
        $this->updateRequirementsList();
    }

    public function updatedCreatedBy()
    {
        $this->resetPage();
    }

    public function updateBuildsList()
    {
        $this->builds = Build::where('project_id', auth()->user()->default_project)
            ->get(['id', 'name']);

        // Reset dependent fields
        $this->build_id = null;
        $this->updateModulesList();
    }

    public function updateModulesList()
    {
        $this->modules = Module::where('project_id', auth()->user()->default_project)
            ->where('build_id', $this->build_id)
            ->get(['id', 'module_name']);

        // Reset dependent field
        $this->module_id = null;
        $this->updateRequirementsList();
    }

    public function updateRequirementsList()
    {
        $this->requirements = Requirement::where('project_id', auth()->user()->default_project)
            ->where('build_id', $this->build_id)
            ->where('module_id', $this->module_id)
            ->get(['id', 'requirement_title']);

        $this->requirement_id = null;
    }

    public function applyFilter()
    {
        $this->resetPage();
    }

    public function clearFilter()
    {
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->created_by = null;
    }

    // Table controller methods
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
        $this->resetPage();
    }

    public function updatingPerPage()
    {
        $this->resetPage();
    }

    public function setSortBy($column)
    {
        if ($this->sortBy === $column) {
            $this->sortDir = $this->sortDir === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->sortBy = $column;
            $this->sortDir = 'ASC';
        }
    }

    public function getSortColumn()
    {
        return $this->sortBy;
    }

    #[On('test_scenario_saved')]
    public function refreshTable()
    {
        $this->resetPage();
    }

    public function edit($id)
    {
        $this->dispatch('editTestScenario', id: $id);
    }

    public function delete($id)
    {
        $ts = TestScenario::where('id', $id)
            ->where('project_id', auth()->user()->default_project)
            ->first();

        if ($ts) {
            $ts->delete();
        }
        $this->resetPage();
        Toaster::success('Test scenario deleted');
    }

    public function render()
    {
        $test_scenarios = TestScenario::with(['build', 'module', 'requirement', 'createdBy'])
            ->when($this->search, function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })
            ->when($this->build_id, function ($query) {
                $query->where('build_id', $this->build_id);
            })
            ->when($this->module_id, function ($query) {
                $query->where('module_id', $this->module_id);
            })
            ->when($this->requirement_id, function ($query) {
                $query->where('requirement_id', $this->requirement_id);
            })
            ->when($this->created_by, function ($query) {
                $query->where('created_by', $this->created_by);
            })
            ->orderBy($this->getSortColumn(), $this->sortDir)
            ->where('project_id', auth()->user()->default_project)
            ->paginate($this->perPage);

        return view('livewire.test-scenario.ts-data-table', compact('test_scenarios'));
    }
}
