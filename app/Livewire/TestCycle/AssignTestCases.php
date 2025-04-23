<?php

namespace App\Livewire\TestCycle;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestCaseTestCycle;
use App\Models\TestCycle;
use App\Models\TestCase;
use App\Models\TestScenario;
use Livewire\Component;
use Livewire\WithPagination;

class AssignTestCases extends Component
{
    use WithPagination;
    public $test_cycle;

    public function mount($test_cycle_id)
    {
        $this->test_cycle = TestCycle::where('project_id', auth()->user()->default_project)
            ->where('id', $test_cycle_id)
            ->first();

        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();
    }

    public function assignTestCase($test_case_id)
    {
        $this->test_cycle->testCases()->attach($test_case_id, [
            'status' => 'Not Executed',
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }

    public function unassignTestCase($test_case_id)
    {
        $this->test_cycle->testCases()->detach($test_case_id);
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

    // Assigned Test Case Table attributes
    public $assignedSearch = '';
    public $assignedSortBy = 'created_at';
    public $assignedSortDir = 'DESC';
    public $assignedPerPage = 20;

    // Table controller methods
    public function updatingAssigendSearch()
    {
        $this->resetPage();
    }

    public function resetAssigendSearch()
    {
        $this->assignedSearch = '';
        $this->resetPage();
    }

    public function updatingAssigendPerPage()
    {
        $this->resetPage();
    }

    public function setAssigendSortBy($column)
    {
        if ($this->assignedSortBy === $column) {
            $this->assignedSortDir = $this->assignedSortDir === 'ASC' ? 'DESC' : 'ASC';
        } else {
            $this->assignedSortBy = $column;
            $this->assignedSortDir = 'ASC';
        }
    }

    public function getAssignedSortColumn()
    {
        return $this->assignedSortBy;
    }

    public function render()
    {
        $assigned_test_cases = TestCase::whereIn('id', TestCaseTestCycle::where('test_cycle_id', $this->test_cycle->id)->pluck('test_case_id'))
            ->when($this->assignedSearch, function ($query) {
            $query->where('tc_name', 'like', '%' . $this->assignedSearch . '%');
            })
            ->where('tc_status', 'approved')
            ->orderBy($this->assignedSortBy, $this->assignedSortDir)
            ->paginate($this->assignedPerPage);

        $excluded_ids = TestCaseTestCycle::where('test_cycle_id', $this->test_cycle->id)
            ->pluck('test_case_id');

        $available_test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->whereNotIn('id', $excluded_ids)
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
            ->where('tc_status', 'approved')
            ->paginate(20);
        return view('livewire.test-cycle.assign-test-cases', compact('available_test_cases', 'assigned_test_cases'));
    }
}
