<?php

namespace App\Livewire\Team;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toast;
use Masmerise\Toaster\Toaster;

class Team extends Component
{
    use WithPagination;
    // public $users;
    public $team;

    public $selected_user_ids;

    public $project_id;

       // User Table controllers
       public $search = '';
       public $userType = '';
       public $sortBy = 'created_at';
       public $sortDir = 'DESC';
       public $perPage = 20;

    public function mount()
    {
        $this->project_id = auth()->user()->default_project;
        // $this->users = [];
        $this->team = [];

        $this->getTeam();
        $this->selected_user_ids = $this->team->pluck('user_id')->toArray();
    }

    public function getTeam()
    {
        $this->team = \App\Models\Team::where('project_id', $this->project_id)
            ->get('user_id');
    }

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
        return $this->sortBy;
    }

    public function saveTeam()
    {
        $this->validate([
            'selected_user_ids' => 'nullable|array',
        ]);

        $this->team = \App\Models\Team::where('project_id', $this->project_id)
            ->delete();

        foreach ($this->selected_user_ids as $userId) {
            \App\Models\Team::create([
                'user_id' => $userId,
                'project_id' => $this->project_id,
            ]);
        }
        $this->resetPage();
        $this->getTeam();
        $this->selected_user_ids = $this->team->pluck('user_id')->toArray();
        Toaster::success('Team members updated successfully!');
    }

    public function render()
    {
        $users = User::with('role')
            ->when($this->search, function ($query) {
            $query->where(function ($query) {
                $searchTerms = explode(' ', $this->search);
                foreach ($searchTerms as $term) {
                    $query->where(function ($query) use ($term) {
                        $query->where('name', 'like', '%' . implode('%', str_split($term)) . '%')
                              ->orWhere('email', 'like', '%' . implode('%', str_split($term)) . '%');
                    });
                }
            });
            })
            ->when($this->userType, function ($query) {
                $query->where('role_id', $this->userType);
            })
            ->where('organization_id', auth()->user()->organization_id)
            ->whereHas('role', function ($query) {
                $query->whereNotNull('name')->where('name', '!=', 'admin');
            })
            ->orderBy($this->getSortColumn(), $this->sortDir)
            ->paginate($this->perPage);
            // dd($users);
        $roles = Role::where('organization_id', auth()->user()->organization_id)
            ->orWhere('default', true)
            ->whereNot('id', 1)
            ->get();

        return view('livewire.team.team', compact(['users', 'roles']));
    }
}
