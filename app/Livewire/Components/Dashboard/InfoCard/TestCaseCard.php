<?php

namespace App\Livewire\Components\Dashboard\InfoCard;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestCase;
use App\Models\TestScenario;
use Livewire\Component;

class TestCaseCard extends Component
{
    public function mount()
    {
        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();
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
    }

    // filter: test case type field data handling
    public $testing_type = null;
    public function updatedTestingType()
    {
        if ($this->testing_type == 'all') {
            $this->testing_type = null;
        }
    }

    public function clearFilters()
    {
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->test_scenario_id = null;
        $this->status = null;
        $this->testing_type = null;

        $this->updateBuildsList();
    }
    public function render()
    {
        $total_test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->when($this->build_id, function ($query) {
                return $query->where('tc_build_id', $this->build_id);
            })
            ->when($this->module_id, function ($query) {
                return $query->where('tc_module_id', $this->module_id);
            })
            ->when($this->requirement_id, function ($query) {
                return $query->where('tc_requirement_id', $this->requirement_id);
            })
            ->when($this->status, function($query){
                $query->where('tc_status', $this->status);
            })
            ->when($this->testing_type, function($query){
                $query->where('tc_testing_type', $this->testing_type);
            })
            ->count();

        $unapproved_test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->when($this->build_id, function ($query) {
                return $query->where('tc_build_id', $this->build_id);
            })
            ->when($this->module_id, function ($query) {
                return $query->where('tc_module_id', $this->module_id);
            })
            ->when($this->requirement_id, function ($query) {
                return $query->where('tc_requirement_id', $this->requirement_id);
            })
            ->when($this->status, function($query){
                $query->where('tc_status', $this->status);
            })
            ->when($this->testing_type, function($query){
                $query->where('tc_testing_type', $this->testing_type);
            })
            ->where('tc_status', 'pending')
            ->count();

        return view('livewire.components.dashboard.info-card.test-case-card', compact('total_test_cases', 'unapproved_test_cases'));
    }
}
