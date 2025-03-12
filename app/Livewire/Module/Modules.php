<?php

namespace App\Livewire\Module;

use App\Models\Build;
use App\Models\Module;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Modules extends Component
{
    use WithPagination;
    public $createModule = false;
    public $editModule = false;

    // Form Attributes
    public $module;
    public $module_name;
    public $module_description;
    public $build_id;
    protected $rules = [
        'module_name' => 'required|string|min:3|max:255',
        'module_description' => 'required|string|min:3|max:500',
        'build_id' => 'nullable|integer'
    ];

    // Data table controllers
    #[Url(as: 'q', except: '')]
    public $search = '';
    public $sortBy = 'module_name';
    public $sortDir = 'ASC';
    public $perPage = 20;
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
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
        return $this->sortBy === 'module_name' ? 'module_name' : 'created_at';
    }

    // Mount method to initialize values
    public function mount() {
        $this->moudule_name = '';
        $this->module_description = '';
        $this->module = null;
        $this->build_id = null;
    }

    public function resetForm() {
        // $this->resetPage();
        $this->reset();
    }

    public function save()
    {
        $this->validate();

        // Ensure module name is unique within the same organization
        $existingModule = Module::where('module_name', $this->module_name)
            ->where('project_id', auth()->user()->default_project)
            ->first();

        if ($this->editModule) {
            if ($existingModule && $this->module && $existingModule->id !== $this->module->id) {
                $this->addError('module_name', 'Module already exist.');
                return;
            }
            $this->module->update([
                'module_name' => $this->module_name,
                'module_description' => $this->module_description,
                'build_id' => $this->build_id
            ]);
            Toaster::success('Module updated successfully');
        } else {
            if ($existingModule) {
                $this->addError('module_name', 'Module already exist.');
                return;
            }
            Module::create([
                'module_name' => $this->module_name,
                'module_description' => $this->module_description,
                'build_id' => $this->build_id,
                'project_id' => auth()->user()->default_project,
            ]);
            Toaster::success('Module created successfully');
        }

        $this->reset();
        $this->editModule = false;
        $this->createModule = false;
    }

    public function edit($moduleId) {
        $module = Module::findOrFail($moduleId);
        $this->module = $module;
        $this->module_name = $this->module->module_name;
        $this->module_description = $this->module->module_description;
        $this->build_id = $this->module->build_id;
        $this->editModule = true;
        $this->createModule = false;
    }

    public function delete($moduleId) {
        Module::findOrFail($moduleId)->delete();
        Toaster::success('Module Deleted');
    }


    public function render()
    {
        $modules = Module::with('build')
        ->when($this->search, function ($query) {
            $searchTerms = '%' . implode('%', str_split($this->search)) . '%';
            $query->where(function ($query) use ($searchTerms) {
            $query->where('module_name', 'like', $searchTerms)
                  ->orWhereHas('build', function ($query) use ($searchTerms) {
                  $query->where('name', 'like', $searchTerms);
                  });
            });
        })
        ->where('project_id', auth()->user()->default_project)
        ->orderBy($this->getSortColumn(), $this->sortDir)
        ->paginate($this->perPage);

        $builds = Build::where('project_id', auth()->user()->default_project)->get(['name', 'id']);
        return view('livewire.module.modules', compact(['modules', 'builds']));
    }
}
