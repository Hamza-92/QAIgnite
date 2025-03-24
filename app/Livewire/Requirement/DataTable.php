<?php

namespace App\Livewire\Requirement;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;

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
    public function refreshTable()
    {
        $this->resetPage();
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
            ->orderBy($this->getSortColumn(), $this->sortDir)
            ->where('project_id', auth()->user()->default_project)
            ->paginate($this->perPage);

        return view('livewire.requirement.data-table', compact('requirements'));
    }
}
