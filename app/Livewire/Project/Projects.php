<?php

namespace App\Livewire\Project;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Projects extends Component
{
    use WithPagination;

    public $createProject = false;
    protected $queryString = ['createProject'];
    public $editProject = false;

    public $project;
    public $name;
    public $description;
    public $status;
    public array $types;
    public array $devices;
    public array $os;
    public array $browsers;

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
        $this->devices = [];
        $this->os = [];
        $this->browsers = [];
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

    public function addOs($os_type)
    {
        if (!in_array($os_type, $this->os)) {
            $this->os[] = $os_type;
        }
    }

    public function removeOs($index)
    {
        unset($this->os[$index]);
    }

    public function addDevice($device)
    {
        if (!in_array($device, $this->devices)) {
            $this->devices[] = $device;
        }
    }

    public function removeDevice($index)
    {
        unset($this->devices[$index]);
    }

    public function addBrowser($browser)
    {
        if (!in_array($browser, $this->browsers)) {
            $this->browsers[] = $browser;
        }
    }

    public function removeBrowser($index)
    {
        unset($this->browsers[$index]);
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
        $this->devices = [];
        $this->os = [];
        $this->browsers = [];
    }

    public function edit($id)
    {
        // dd("editing project");
        $this->project = Project::find($id);
        $this->name = $this->project->name;
        $this->description = $this->project->description  ?? "";
        $this->status = $this->project->status;
        $this->types = $this->project->type ?? [];
        $this->devices = $this->project->devices  ?? [];
        $this->os = $this->project->os  ?? [];
        $this->browsers = $this->project->browsers  ?? [];
        $this->editProject = true;
    }

    public function archiveProject($id) {
        $project = Project::find($id);
        $project->update([
            'is_archived' => true
        ]);
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
            'os' => 'array|nullable|sometimes',
            'devices' => 'array|nullable|sometimes',
            'browsers' => 'array|nullable|sometimes',
        ]);
        if ($this->createProject) {
            Project::create([
                'name' => $this->name,
                'description' => $this->description,
                'type' => $this->types,
                'status' => $this->status,
                'devices' => $this->devices,
                'os' => $this->os,
                'browsers' => $this->browsers,
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
                'devices' => $this->devices,
                'os' => $this->os,
                'browsers' => $this->browsers,
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
