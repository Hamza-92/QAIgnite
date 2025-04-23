<?php

namespace App\Livewire\User;

use App\Mail\InvitationMail;
use App\Models\Invitation;
use App\Models\Organization;
use App\Models\Role;
use App\Models\TestCycle;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;
use Mail;
use Masmerise\Toaster\Toaster;
use Str;

class Users extends Component
{
    use WithPagination;
    public $createUser = false;
    public $editUser = false;

    public $invitation;
    public $name = '';
    public $email = '';
    public $role;
    public $organization_id;

    // User Table controllers
    public $search = '';
    public $userType = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $perPage = 20;

    // User Table controllers
    public $invitationSearch = '';
    public $invitationUserType = '';
    public $invitationSortBy = 'created_at';
    public $invitationSortDir = 'DESC';
    public $invitationPerPage = 20;

    public function mount()
    {

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
        return $this->sortBy === 'name' ? 'name' : 'created_at';
    }
    // Invitation table controller
    public function updatingInvitationSearch()
    {
        $this->resetPage();
    }
    public function invitationResetSearch() {
        $this->invitationSearch = '';
    }
    public function updatingInvitationPerPage()
    {
        $this->resetPage();
    }
    public function setInvitationSortBy($column)
    {
        if ($this->invitationSortBy === $column) {
            $this->invitationSortDir = $this->invitationSortDir === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->invitationSortBy = $column;
            $this->invitationSortDir = 'ASC';
        }
    }
    public function getInvitationSortColumn()
    {
        return $this->invitationSortBy === 'name' ? 'name' : 'created_at';
    }

    public function resetForm()
    {
        $this->createUser = false;
        $this->editUser = false;
        $this->reset(['name', 'email', 'role']);
    }

    public function resendMail($id) {
        $invitation = Invitation::findOrFail($id);
        $token = Str::random(40);
        $role = Role::find($invitation->role_id);
        $organization = Organization::find(auth()->user()->organization_id);

        $invitation->update([
            'token' => $token,
        ]);

        $invitation = [
            'name' => $invitation->name,
            'email' => $invitation->email,
            'role_name' => $role['name'],
            'organization_name' => $organization['name'],
            'token' => $token,
        ];

        Mail::to($invitation['email'])->send(new InvitationMail($invitation));

        Toaster::success('Invitation mail sent successfully.');
    }

    public function createInvitation()
    {
        $this->createUser = true;
        $this->editUser = false;
    }
    public function editInvitation($id)
    {
        $this->createUser = false;
        $this->editUser = true;
        $this->invitation = Invitation::findOrFail($id);
        $this->name = $this->invitation->name;
        $this->email = $this->invitation->email;
        $this->role = $this->invitation->role_id;
    }

    public function deleteInvitation($id) {
        Invitation::findOrFail($id)->delete();
        Toaster::success('Invitation deleted.');
    }

    public function deleteUser($id) {
        User::findOrFail($id)->delete();
        Toaster::success('User deleted.');
    }

    public function save()
    {
        if ($this->createUser) {
            $this->validate([
                'name' => 'required|string|min:3|max:255',
                'email' => 'required|email|unique:users,email|unique:invitations,email',
                'role' => [
                    'required',
                    'exists:roles,id',
                    function ($attribute, $value, $fail) {
                        $role = Role::where('id', $value)
                            ->where(function ($query) {
                                $query->where('organization_id', auth()->user()->organization_id)
                                      ->orWhere('default', true);
                            })
                            ->first();
                        if (!$role) {
                            $fail('The selected role is invalid.');
                        }
                    },
                ],
            ]);

            $token = Str::random(40);
            $role = Role::find($this->role);
            $organization = Organization::find(auth()->user()->organization_id);

            $invitation = [
                'name' => $this->name,
                'email' => $this->email,
                'role_name' => $role['name'],
                'organization_name' => $organization['name'],
                'token' => $token,
            ];

            Mail::to($this->email)->send(new InvitationMail($invitation));

            Invitation::create([
                'name' => $this->name,
                'email' => $this->email,
                'role_id' => $this->role,
                'organization_id' => auth()->user()->organization_id,
                'token' => $token,
            ]);

            Toaster::success('User invited successfully.');

        } elseif ($this->editUser) {
            $this->validate([
            'name' => 'required|string|min:3|max:255',
            'email' => 'required|email|unique:invitations,email,' . $this->invitation->id,
            'role' => 'required|exists:roles,id',
            ]);

            $this->invitation->update([
            'name' => $this->name,
            'email' => $this->email,
            'role_id' => $this->role,
            ]);

            $token = Str::random(40);
            $role = Role::find($this->role);
            $organization = Organization::find(auth()->user()->organization_id);

            $invitation = [
            'name' => $this->name,
            'email' => $this->email,
            'role_name' => $role['name'],
            'organization_name' => $organization['name'],
            'token' => $token,
            ];

            Mail::to($this->email)->send(new InvitationMail($invitation));

            Toaster::success('User updated successfully.');
            Toaster::success('Mail resent successfully.');
        }
        $this->resetForm();
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
                $query->where('name', '!=', 'admin');
            })
            ->orderBy($this->getSortColumn(), $this->sortDir)
            ->paginate($this->perPage);

        $invitations = Invitation::with('role')
            ->when($this->invitationSearch, function ($query) {
                $query->where(function ($query) {
                    $query->where('name', 'like', '%' . $this->search . '%')
                        ->orWhere('email', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->invitationUserType, function ($query) {
                $query->where('role_id', $this->invitationUserType);
            })
            ->where('organization_id', auth()->user()->organization_id)
            ->orderBy($this->getInvitationSortColumn(), $this->invitationSortDir)
            ->paginate($this->invitationPerPage);

        $roles = Role::where('organization_id', auth()->user()->organization_id)
            ->orWhere('default', true)
            ->whereNot('id', 1)
            ->get();

        return view('livewire.user.users', compact(['users', 'roles', 'invitations']));
    }

    public function assignedCycles() {
        return $this->belongsToMany(TestCycle::class, 'test_cycle_user');
    }
}
