<?php

namespace App\Livewire\Reports\TestCase;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestScenario;
use App\Models\User;
use Livewire\Component;

class TestCaseReport extends Component
{
    public function mount() {
        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();
        $this->loadAssignedUsers();
    }

    // Filter: build field data handling
    public $builds;
    public $build_id;
    public function updatedBuildId()
    {
        if ($this->build_id == 'all') {
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
        if ($this->module_id == 'all') {
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
        if ($this->requirement_id == 'all') {
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
        if ($this->test_scenario_id == 'all') {
            $this->test_scenario_id = null;
        }
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

    public $test_case_status;
    public function updatedTestCaseStatus() {
        if ($this->test_case_status == 'all') {
            $this->test_case_status = null;
        }
    }

    public $execution_status;
    public function updatedExecutionStatus() {
        if ($this->test_case_status == 'all') {
            $this->test_case_status = null;
        }
    }

    public $testing_type;
    public function updatedTestingType() {
        if ($this->testing_type == 'all') {
            $this->testing_type = null;
        }
    }

    public $assigned_users;
    public function loadAssignedUsers() {
        $this->assigned_users = User::whereHas('assigned_test_cases')->get(['id', 'username']);
    }
    public function render()
    {
        return view('livewire.reports.test-case.test-case-report');
    }
}
