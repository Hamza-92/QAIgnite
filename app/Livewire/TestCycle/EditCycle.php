<?php

namespace App\Livewire\TestCycle;

use App\Models\Build;
use App\Models\TestCycle;
use App\Models\User;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class EditCycle extends Component
{
    public $test_cycle;
    public $name;
    public $description;
    public $start_date;
    public $end_date;
    public $status;
    public $visibility;
    public $project_id;
    public $build_id;
    public $assigned_to;
    public function mount($test_cycle_id)
    {
        $this->test_cycle = TestCycle::where('id', $test_cycle_id)
            ->where('project_id', auth()->user()->default_project)
            ->get()->first();

        if (! $this->test_cycle) {
            Toaster::error('Test cycle not found.');
            $this->redirect(route('test-cycles'), true);
        }
        $this->name = $this->test_cycle->name;
        $this->description = $this->test_cycle->description;
        $this->start_date = $this->test_cycle->start_date;
        $this->end_date = $this->test_cycle->end_date;
        $this->status = $this->test_cycle->status;
        $this->visibility = $this->test_cycle->visibility === 'private';
        $this->project_id = $this->test_cycle->project_id;
        $this->build_id = $this->test_cycle->build_id;
        $this->assigned_to = $this->test_cycle->assignees->pluck('id')->toArray();

        $this->loadFormBuilds();
        $this->loadFormUsers();

        $this->form_selected_build_name = $this->test_cycle->build ? $this->test_cycle->build->name : null;
        $this->form_selected_users = $this->test_cycle->assignees->map(function ($assignee) {
            return ['id' => $assignee->id, 'username' => $assignee->username];
        })->toArray();
        // dd([
        //     'Assigned To' => $this->assigned_to,
        //     'Build Name'  => $this->form_selected_build_name,
        //     'users' => $this->form_selected_users
        // ]);
    }

    /* -- Form build field data halndling -- */
    public $form_builds; // List of builds
    public $form_search_build; // Search query
    public $form_selected_build_name;

    public function loadFormBuilds()
    {
        $this->form_builds = Build::when($this->form_search_build, function ($query) {
            $query->where('name', 'like', "%{$this->form_search_build}%");
        })
            ->where('project_id', auth()->user()->default_project)
            ->get(['id', 'name']);
    }

    public function updatedFormSearchBuild()
    {
        $this->loadFormBuilds();
    }

    public function assignBuildID($build)
    {
        if ($this->build_id === $build['id']) {
            return;
        }
        $this->build_id = $build['id'];
        $this->form_selected_build_name = $build['name'];
    }

    public function resetBuildID()
    {
        $this->build_id = null;
        $this->form_selected_build_name = null;
    }

    /* -- Form build field data halndling -- */
    public $form_users; // List of builds
    public $form_search_user; // Search query
    public $form_selected_users = [];

    public function loadFormUsers()
    {
        $this->form_users = User::when($this->form_search_user, function ($query) {
            $query->where('username', 'like', "%{$this->form_search_user}%");
        })
            ->where('organization_id', auth()->user()->organization_id)
            ->get(['id', 'username']);
    }

    public function updatedFormSearchUser()
    {
        $this->loadFormUsers();
    }

    public function assignUser($user)
    {
        if (! in_array($user['id'], $this->assigned_to)) {
            $this->assigned_to[] = $user['id'];
            $this->form_selected_users[] = $user;
        }
    }

    public function removeUser($id)
    {
        $this->assigned_to = array_filter($this->assigned_to, function ($userId) use ($id) {
            return $userId !== $id;
        });

        $this->form_selected_users = array_filter($this->form_selected_users, function ($user) use ($id) {
            return $user['id'] !== $id;
        });
    }

    public function save() {
        $this->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                function ($attribute, $value, $fail) {
                    if (TestCycle::where('name', $value)
                        ->where('project_id', auth()->user()->default_project)
                        ->where('id', '!=', $this->test_cycle->id)
                        ->exists()) {
                        $fail('The name has already been taken.');
                    }
                },
            ],
            'description' => 'nullable|string|max:1500',
            'start_date' => 'nullable|date|after_or_equal:today',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'required|string|in:In Progress,Completed,On Hold',
            'visibility' => 'required|boolean',
            'project_id' => 'required|exists:projects,id',
            'build_id' => 'nullable|exists:builds,id',
            'assigned_to' => 'nullable|array',
            'assigned_to.*' => 'exists:users,id',
        ]);

        $this->test_cycle->update([
            'name' => $this->name,
            'description' => $this->description,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'status' => $this->status,
            'visibility' => $this->visibility ? 'private' : 'public',
            'project_id' => $this->project_id,
            'build_id' => $this->build_id,
            'updated_by' => auth()->user()->id,
        ]);

        if (!empty($this->assigned_to)) {
            $this->test_cycle->assignees()->sync($this->assigned_to);
        }
        $this->redirect(route('test-cycles'), true);
        Toaster::success('Cycle updated successfully');
    }
    public function render()
    {
        return view('livewire.test-cycle.edit-cycle');
    }
}
