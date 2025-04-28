<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Projects extends Component
{
    use WithPagination;

    public $createProject = false;
    public $editProject = false;

    public $project;
    public $project_detail;
    public $name;
    public $description;
    public $status;
    public array $types;

    // Table Properties
    public $search = '';
    public $sortBy = 'name';
    public $sortDir = 'ASC';
    public $perPage = 20;

    public function mount()
    {
        $this->project = null;
        $this->name = '';
        $this->description = '';
        $this->status = 'In Progress';
        $this->types = [];

        $this->createProject = session()->pull('create_project');
    }

    // Table Methods
    public function updatingSearch()
    {
        $this->resetPage();
    }
    public function resetSearch() {
        $this->search = '';
    }
    public function getSortColumn()
    {
        return $this->sortBy === 'name' ? 'name' : 'created_at';
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

    public function addType($type)
    {
        if (!in_array($type, $this->types)) {
            $this->types[] = $type;
        }
    }

    public function removeType($index)
    {
        unset($this->types[$index]);
    }

    public function loadProject($project_id) {
        $this->project_detail = Project::findOrFail($project_id);
        if(! $this->project_detail) {
            Toaster::error('Project not found');
        }
    }

    public function resetForm()
    {
        $this->createProject = false;
        $this->editProject = false;

        $this->project = null;
        $this->name = '';
        $this->description = '';
        $this->status = 'In Progress';
        $this->types = [];
    }

    public function edit($id)
    {
        // dd("editing project");
        $this->project = Project::find($id);
        $this->name = $this->project->name;
        $this->description = $this->project->description  ?? "";
        $this->status = $this->project->status;
        $this->types = $this->project->type ?? [];
        $this->editProject = true;
    }

    public function archiveProject($id) {
        $project = Project::find($id);
        $project->update([
            'is_archived' => true
        ]);
        if(auth()->user()->default_project == $id) {
            $user = Auth::user();
            $user->default_project = null;
            $user->save();
            $this->redirect(request()->header('Referer'), navigate: true);
        }
        Toaster::success('Project archived successfully');
    }

    public function save()
    {
        $projectId = $this->project->id ?? 'NULL';
        $this->validate([
            'name' => 'required|min:3|max:255|unique:projects,name,' . $projectId,
            'description' => 'nullable|sometimes|min:3|max:5000',
            'status' => 'required|string|in:In Progress,On Hold,Completed',
            'types' => 'array|nullable|sometimes',
        ]);
        if ($this->createProject) {
            Project::create([
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->types,
                'status' => $this->status,
                'user_id' => auth()->user()->id,
                'organization_id' => auth()->user()->organization_id,
            ]);

            Toaster::success('Project created successfully');
        } elseif($this->editProject) {
            $this->project->update([
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->types,
                'status' => $this->status,
            ]);

            Toaster::success('Project updated successfully');
        }
        $this->resetForm();

    }
    public function render()
    {
        $projects = Project::with('user')
            ->when($this->search, function ($query) {
            $searchTerms = '%' . implode('%', str_split($this->search)) . '%';
            $query->where(function ($query) use ($searchTerms) {
                $query->where('name', 'like', $searchTerms)
                ->orWhere('description', 'like', $searchTerms)
                ->orWhereHas('user', function ($query) use ($searchTerms) {
                    $query->where('name', 'like', $searchTerms);
                });
            });
            })
            ->where('organization_id', auth()->user()->organization_id)
            ->whereNot('is_archived', true)
            ->orderBy($this->getSortColumn(), $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.project.projects', compact('projects'));
    }
}
