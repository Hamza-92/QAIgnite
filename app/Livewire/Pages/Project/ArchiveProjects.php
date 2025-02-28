<?php

namespace App\Livewire\Pages\Project;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class ArchiveProjects extends Component
{
    use WithPagination;
    public $search = '';
    public $sortBy = 'name';
    public $sortDir = 'ASC';
    public $perPage = 20;

    public function resetSearch() {
        $this->search = '';
    }

    public function updatingSearch()
    {
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
        return $this->sortBy === 'projectName' ? 'name' : 'created_at';
    }

    public function restore($projectId) {
        $project = Project::findOrFail($projectId);
        $project->update(['is_archived' => false]);
        Toaster::success('Project restored!');
    }

    public function delete($projectId) {
        Project::findOrFail($projectId)->delete();
        Toaster::error('Project Deleted!');
    }
    public function render()
    {
        $projects = Project::when($this->search, function ($query) {
            $searchTerms = '%' . implode('%', str_split($this->search)) . '%';
            $query->where(function ($query) use ($searchTerms) {
                $query->where('name', 'like', $searchTerms);
            });
            })
        ->where('organization_id', auth()->user()->organization_id)
        ->where('is_archived', true)
        ->orderBy($this->getSortColumn(), $this->sortDir)
        ->paginate($this->perPage);

        return view('livewire.pages.project.archive-projects', compact('projects'));
    }
}
