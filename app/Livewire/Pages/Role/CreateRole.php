<?php

namespace App\Livewire\Pages\Role;

use App\Models\Role;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class CreateRole extends Component
{
    public $name = '';
    public $description = '';
    public $permissions = [];
    public $deletable = false;
    public $rules = [
        'name' => 'required|string|max:255',
        'description' => 'required|string|max:500',
        'permissions' => 'array',
        'deletable' => 'boolean'
    ];

    public function saveRole() {
        $validate = $this->validate();

        // dd($validate["name"], $validate["description"], $validate["permissions"], $this->deletable, Auth::user()->organization_id);
        Role::create([
            'name' => $validate["name"],
            'description' => $validate["description"],
            'permissions' => $validate["permissions"],
            'deletable' => $this->deletable,
            'organization_id' => auth()->user()->organization_id,
        ]);
        Toaster::success('New role added successfully.');
        return redirect()->route('roles')->with('navigate', true);
    }
    public function render()
    {
        return view('livewire.pages.role.create-role');
    }
}
