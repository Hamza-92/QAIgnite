<?php

namespace App\Livewire\TestCase;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestCase;
use App\Models\TestScenario;
use App\Models\User;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class DataTable extends Component
{
    use WithPagination;

    public $total_test_cases;
    public $approved_test_cases;
    public $rejected_test_cases;
    public $pending_test_cases;

    public function getInfo() {
        $this->total_test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)->count();
        $this->approved_test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->where('tc_status', 'approved')->count();
        $this->rejected_test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->where('tc_status', 'rejected')->count();
        $this->pending_test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->where('tc_status', 'pending')->count();
    }
    public function mount() {
        $this->getInfo();

        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->test_scenario_id = null;
        $this->status = null;
        $this->execution_type = null;
        $this->created_by = null;
        $this->assigned_to = null;
        $this->approval_requested = null;
        $this->search = '';
        $this->sortBy = 'created_at';
        $this->sortDir = 'DESC';
        $this->perPage = 20;
        $this->builds = [];
        $this->modules = [];
        $this->requirements = [];
        $this->test_scenarios = [];
        $this->created_by_users = [];
        $this->assigned_to_users = [];
        $this->approval_requested_users = [];
        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();

        $this->getCreatedByUsers();
        $this->getAssignedToUsers();
        $this->getApprovalRequestedUsers();
    }
    // Filter: build field data handling
    public $builds;
    public $build_id;
    public function updatedBuildId()
    {
        if($this->build_id == 'all') {
            $this->build_id = null;
        }
        $this->updateModulesList();
    }
    public function updateBuildsList()
    {
        $this->builds = Build::where('project_id', auth()->user()->default_project)
            ->get(['id', 'name']);

        // Reset dependent fields
        $this->build_id = null;
        $this->updateModulesList();
    }

    // Filter: module field data handling
    public $modules;
    public $module_id;
    public function updatedModuleId()
    {
        if($this->module_id == 'all') {
            $this->module_id = null;
        }
        $this->updateRequirementsList();
    }
    public function updateModulesList()
    {
        $this->modules = Module::where('project_id', auth()->user()->default_project)
            ->where('build_id', $this->build_id)
            ->get(['id', 'module_name']);

        // Reset dependent field
        $this->module_id = null;
        $this->updateRequirementsList();
    }

    // Filter: requirement field data handling
    public $requirements;
    public $requirement_id;
    public function updatedRequirementId()
    {
        if($this->requirement_id == 'all') {
            $this->requirement_id = null;
        }
        $this->updateTestScenariosList();
    }
    public function updateRequirementsList()
    {
        $this->requirements = Requirement::where('project_id', auth()->user()->default_project)
            ->where('build_id', $this->build_id)
            ->where('module_id', $this->module_id)
            ->get(['id', 'requirement_title']);

        $this->requirement_id = null;
        $this->updateTestScenariosList();
    }
    // Filter: test scenario field data handling
    public $test_scenarios;
    public $test_scenario_id;
    public function updatedTestScenarioId()
    {
        if($this->test_scenario_id == 'all') {
            $this->test_scenario_id = null;
        }
        $this->resetPage();
    }
    public function updateTestScenariosList()
    {
        $this->test_scenarios = TestScenario::where('ts_project_id', auth()->user()->default_project)
            ->where('ts_build_id', $this->build_id)
            ->where('ts_module_id', $this->module_id)
            ->where('ts_requirement_id', $this->requirement_id)
            ->get(['id', 'ts_name']);

        $this->test_scenario_id = null;
    }

    // filter: status field data handling
    public $status = null;
    public function updatedStatus()
    {
        if ($this->status == 'all') {
            $this->status = null;
        }
        $this->resetPage();
    }

    // filter: test case type field data handling
    public $testing_type = null;
    public function updatedTestingType()
    {
        if ($this->testing_type == 'all') {
            $this->testing_type = null;
        }
        $this->resetPage();
    }

    // filter: execution type field data handling
    public $execution_type = null;
    public function updatedExecutionType()
    {
        if ($this->execution_type == 'all') {
            $this->execution_type = null;
        }
        $this->resetPage();
    }

    // Filter: created_by field data handling
    public $created_by_users;
    public $created_by;
    public function updatedCreatedBy()
    {
        if ($this->created_by == 'all') {
            $this->created_by = null;
        }
        $this->resetPage();
    }
    public function getCreatedByUsers()
    {
        $this->created_by_users = User::whereHas('created_test_cases', function ($query) {
            $query->where('tc_project_id', auth()->user()->default_project);
        })
            ->select('id', 'username')
            ->distinct()
            ->get();
    }

    // Filter: assigned_to field data handling
    public $assigned_to_users;
    public $assigned_to;
    public function updatedAssignedTo()
    {
        if ($this->assigned_to == 'all') {
            $this->assigned_to = null;
        }
        $this->resetPage();
    }
    public function getAssignedToUsers()
    {
        $this->assigned_to_users = User::whereHas('assigned_test_cases', function ($query) {
            $query->where('tc_project_id', auth()->user()->default_project);
        })
            ->select('id', 'username')
            ->distinct()
            ->get();
    }

    // Filter: approval requested field data handling
    public $approval_requested_users;
    public $approval_requested = null;
    public function updatedApprovalRequested()
    {
        if ($this->approval_requested == 'all') {
            $this->approval_requested = null;
        }
        $this->resetPage();
    }
    public function getApprovalRequestedUsers()
    {
        $this->approval_requested_users = User::whereHas('test_case_approval_requests', function ($query) {
            $query->where('tc_project_id', auth()->user()->default_project);
        })
            ->select('id', 'username')
            ->distinct()
            ->get();
    }



    public function clearFilter()
    {
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->test_scenario_id = null;
        $this->status = null;
        $this->testing_type = null;
        $this->execution_type = null;
        $this->created_by = null;
        $this->assigned_to = null;
        $this->approval_requested = null;
        $this->search = '';
        $this->resetPage();

        // Reset dependent lists
        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();
    }


    // Table attributes
    public $search = '';
    public $sortBy = 'created_at';
    public $sortDir = 'DESC';
    public $perPage = 20;

    // Table controller methods
    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function resetSearch()
    {
        $this->search = '';
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
        return $this->sortBy;
    }

    #[On('test_case_saved')]
    public function refreshTable()
    {
        $this->getInfo();
        $this->resetPage();
    }

    public function editTestCase($id)
    {
        $this->dispatch('editTestCase', $id);
    }
    public function deleteTestCase($id)
    {
        $testCase = TestCase::findOrFail($id);
        $testCase->delete();

        Toaster::success('Test case deleted successfully');
        $this->resetPage();
    }
    public function render()
    {
        $test_cases = TestCase::with('build', 'module', 'requirement', 'test_scenario', 'created_by', 'assigned_to')
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $query->where('tc_name', 'like', "%{$this->search}%")
                        ->orWhere('tc_description', 'like', "%{$this->search}%");
                });
            })
            ->where('tc_project_id', auth()->user()->default_project)
            ->when($this->build_id, function($query){
                $query->where('tc_build_id', $this->build_id);
            })
            ->when($this->module_id, function($query){
                $query->where('tc_module_id', $this->module_id);
            })
            ->when($this->requirement_id, function($query){
                $query->where('tc_requirement_id', $this->requirement_id);
            })
            ->when($this->test_scenario_id, function($query){
                $query->where('tc_test_scenario_id', $this->test_scenario_id);
            })
            ->when($this->status, function($query){
                $query->where('tc_status', $this->status);
            })
            ->when($this->testing_type, function($query){
                $query->where('tc_testing_type', $this->testing_type);
            })
            ->when($this->execution_type, function($query){
                $query->where('tc_execution_type', $this->execution_type);
            })
            ->when($this->created_by, function($query){
                $query->where('tc_created_by', $this->created_by);
            })
            ->when($this->assigned_to, function($query){
                $query->where('tc_assigned_to', $this->assigned_to);
            })
            ->when($this->approval_requested, function($query){
                $query->where('tc_approval_request', $this->approval_requested);
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
        return view('livewire.test-case.data-table', compact('test_cases'));
    }
}
