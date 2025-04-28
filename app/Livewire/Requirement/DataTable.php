<?php

namespace App\Livewire\Requirement;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class DataTable extends Component
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

    public $status;

    public $created_by_users;
    public $created_by;

    public function mount()
    {
        $this->build_name = null;
        $this->build_id = null;
        $this->module_id = null;
        $this->status = null;
        $this->created_by = null;

        // List of builds
        $this->builds = Build::where('project_id', auth()->user()->default_project)
            ->get(['id', 'name']);

        // List of modules
        $this->modules = Module::where('build_id', $this->build_id)
            ->where('project_id', auth()->user()->default_project)
            ->get(['id', 'module_name']);

    }

    public function updatedBuildId() {
        if($this->build_id == 'all') {
            $this->build_id = null;
        }
        $this->updateModulesList();
    }

    public function updateModulesList()
    {
        if ($this->build_id == "") {
            $this->build_id = null;
        }
        $this->module_id = null;
        $this->modules = Module::where('build_id', $this->build_id)
            ->where('project_id', auth()->user()->default_project)
            ->get(['id', 'module_name']);
    }

    public function updatedModuleId() {
        if($this->module_id == 'all') {
            $this->module_id = null;
        }
    }

    public function updatedStatus() {
        if($this->status == 'all') {
            $this->status = null;
        }
    }

    public function updatedCreatedBy() {
        if($this->created_by == 'all') {
            $this->created_by = null;
        }
    }

    public function applyFilter()
    {
        $this->resetPage();
    }

    public function clearFilter()
    {
        $this->build_id = null;
        $this->module_id = null;
        $this->status = null;
        $this->created_by = null;
    }

    // Table controller methods
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetSearch() {
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


    public function edit($id)
    {
        $this->dispatch('editRequirement', id: $id);
    }

    #[On('requirement_saved')]
    #[On('requirement_deleted')]
    public function refreshTable()
    {
        $this->resetPage();
    }

    // Delete Requirement
    public function delete($id) {
        Requirement::destroy($id);
        $this->resetPage();
        Toaster::success('Requirement deleted');
    }

    public function render()
    {
        $requirements = Requirement::when($this->search, function ($query) {
            $query->where('requirement_title', 'like', "%{$this->search}%")
                ->orWhereHas('parentRequirement', function ($query) {
                    $query->where('requirement_title', 'like', "%{$this->search}%");
                });
        })
            ->when($this->build_id, function ($query) {
                $query->where('build_id', $this->build_id);
            })
            ->when($this->module_id, function ($query) {
                $query->where('module_id', $this->module_id);
            })
            ->when($this->status, function ($query) {
                $query->where('status', $this->status);
            })
            ->when($this->created_by, function ($query) {
                $query->where('created_by', $this->created_by);
            })
            ->orderBy($this->getSortColumn(), $this->sortDir)
            ->where('project_id', auth()->user()->default_project)
            ->paginate($this->perPage);

            $this->created_by_users = User::whereHas('createdRequirements', function($query) {
                $query->where('project_id', auth()->user()->default_project);
            })
            ->select('id', 'username')
            ->distinct()
            ->get();
        return view('livewire.requirement.data-table', compact('requirements'));
    }
}
