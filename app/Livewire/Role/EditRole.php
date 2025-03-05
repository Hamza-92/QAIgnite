<?php

namespace App\Livewire\Role;

use App\Models\Role;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditRole extends Component
{
    public $role_id;
    public $role;
    public $name;
    public $description;
    public $permissions;
    public $deletable;
    public $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'permissions' => 'array',
        'deletable' => 'boolean'
    ];

    public function mount($id) {
        $this->role_id = $id;
        $this->role = Role::where('id', $id)->where('organization_id', auth()->user()->organization_id)->first();
        if ($this->role) {
            $this->name = $this->role->name;
            $this->description = $this->role->description;
            $this->deletable = $this->role->deletable;
            $this->permissions = $this->role->permissions;
        } else {
            Toaster::error('Role not found.');
            return redirect()->route('roles');
        }
    }

    public function saveRole() {
        $validate = $this->validate();

        // dd($validate["name"], $validate["description"], $validate["permissions"], $this->deletable, Auth::user()->organization_id);
        $this->role->update([
            'name' => $validate["name"],
            'description' => $validate["description"],
            'permissions' => $validate["permissions"],
            'deletable' => $this->deletable,
        ]);
        Toaster::success('Role updated');
        return $this->redirect(route("roles"), navigate:true);
    }

    public function render()
    {
        return view('livewire.role.edit-role');
    }
}
