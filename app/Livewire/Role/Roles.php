<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Roles extends Component
{
    use WithPagination;

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
        return $this->sortBy === 'name' ? 'name' : 'users_count';
    }

    public function deleteRole($id) {
        Role::find($id)->delete();
        Toaster::success('Role deleted');
    }

    public function render()
    {
        $roles = Role::withCount('users')
            ->where(function ($query) {
                $query->where('organization_id', auth()->user()->organization_id)
                    ->orWhere('default', true);
            })
            ->when($this->search, function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%');
            })
            ->whereNot('id', 1)
            ->orderBy($this->getSortColumn(), $this->sortDir)
            ->paginate($this->perPage);


        return view('livewire.role.roles', compact('roles'));
    }
}
