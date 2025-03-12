<?php

namespace App\Livewire\Build;

use App\Models\Build;
use Livewire\Attributes\Rule;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Builds extends Component
{
    use WithPagination;
    public $createBuild = false;
    public $editBuild = false;

    // Form Attributes
    public $build;
    public $name;
    public $description;
    public $start_date;
    #[Rule('nullable|date|after_or_equal:start_date')]
    public $end_date;

    protected array $rules = [
        'name' => 'required|string|min:3|max:255',
        'description' => 'nullable|string|max:500',
        'start_date' => 'nullable|date|after_or_equal:today',
        'end_date' => 'nullable|date|after_or_equal:start_date',
    ];

    // Data table controllers
    #[Url(as: 'q', except: '')]
    public $search = '';
    public $sortBy = 'name';
    public $sortDir = 'ASC';
    public $perPage = 20;
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetSearch() {
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
        return $this->sortBy === 'projectName' ? 'name' : 'created_at';
    }

    // Mount method to initialize values
    public function mount() {
        $this->name = '';
        $this->description = '';
        $this->start_date = null;
        $this->end_date = null;
        $this->build = null;
    }

    public function resetForm() {
        $this->name = '';
        $this->description = '';
        $this->start_date = null;
        $this->end_date = null;
        $this->build = null;
        $this->editBuild = false;
        $this->createBuild = false;
    }

    // Save data
    public function save()
    {
        $this->validate();

        if(isset($this->end_date) && !isset($this->start_date)) {
            $this->addError('start_date', 'Start date must be set before end date');
            return;
        }

        // Ensure project name is unique within the same organization
        $existingBuild = Build::where('name', $this->name)
            ->where('project_id', auth()->user()->default_project)
            ->first();

        if ($this->editBuild) {
            if ($existingBuild && $this->build && $existingBuild->id !== $this->build->id) {
                $this->addError('name', 'Name already exist.');
                return;
            }
            $this->build->update([
                'name' => $this->name,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
            ]);
            Toaster::success('Build updated successfully');
        } else {
            if ($existingBuild) {
                $this->addError('name', 'Build already exist.');
                return;
            }
            Build::create([
                'name' => $this->name,
                'description' => $this->description,
                'start_date' => $this->start_date,
                'end_date' => $this->end_date,
                'user_id' => auth()->user()->id,
                'project_id' => auth()->user()->default_project,
            ]);
            Toaster::success('Build created successfully');
        }

        $this->reset();
        $this->editBuild = false;
        $this->createBuild = false;
    }

    public function edit($buildId) {
        $build = Build::findOrFail($buildId);
        $this->build = $build;
        $this->name = $this->build->name;
        $this->description = $build->description;
        $this->start_date = $build->start_date;
        $this->end_date = $build->end_date;
        $this->editBuild = true;
        $this->createBuild = false;
    }

    public function delete($buildId) {
        Build::findOrFail($buildId)->delete();
        Toaster::success('Build Deleted');
    }

    public function render()
    {
        $builds = Build::when($this->search, function ($query) {
            $searchTerms = '%' . implode('%', str_split($this->search)) . '%';
            $query->where(function ($query) use ($searchTerms) {
                $query->where('name', 'like', $searchTerms);
            });
            })
            ->where('project_id', auth()->user()->default_project)
            ->orderBy($this->getSortColumn(), $this->sortDir)
            ->paginate($this->perPage);
        return view('livewire.build.builds', compact('builds'));
    }
}
