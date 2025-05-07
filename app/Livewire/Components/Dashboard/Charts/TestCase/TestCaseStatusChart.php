<?php

namespace App\Livewire\Components\Dashboard\Charts\TestCase;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestCase;
use App\Models\TestScenario;
use Livewire\Attributes\On;
use Livewire\Component;

class TestCaseStatusChart extends Component
{
    public $testCaseStatusCounts;
    public $testCaseData = [];
    public $showDataModel = false;

    public function mount()
    {
        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();

        $this->getTestCaseStatusCounts();
    }

    public function getTestCaseStatusCounts()
    {
        $counts = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->when($this->build_id, function($query) {
                $query->where('tc_build_id', $this->build_id);
            })
            ->when($this->module_id, function($query) {
                $query->where('tc_module_id', $this->module_id);
            })
            ->when($this->requirement_id, function($query) {
                $query->where('tc_requirement_id', $this->requirement_id);
            })
            ->when($this->test_scenario_id, function($query) {
                $query->where('tc_test_scenario_id', $this->test_scenario_id);
            })
            ->when($this->priority, function($query) {
                $query->where('tc_priority', $this->priority);
            })
            ->when($this->testing_type, function($query) {
                $query->where('tc_testing_type', $this->testing_type);
            })
            ->select('tc_status', \DB::raw('count(*) as count'))
            ->groupBy('tc_status')
            ->pluck('count', 'tc_status')
            ->toArray();

        // Make sure we have all statuses with at least 0 as value
        $this->testCaseStatusCounts = [
            'approved' => $counts['approved'] ?? 0,
            'pending' => $counts['pending'] ?? 0,
            'rejected' => $counts['rejected'] ?? 0
        ];
    }

    #[On('showTestCaseStatusData')]
    public function showTestCaseDataModel($status)
    {
        $this->showDataModel = true;
        $status = strtolower($status);
        $this->testCaseData = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->when($this->build_id, function($query) {
                $query->where('tc_build_id', $this->build_id);
            })
            ->when($this->module_id, function($query) {
                $query->where('tc_module_id', $this->module_id);
            })
            ->when($this->requirement_id, function($query) {
                $query->where('tc_requirement_id', $this->requirement_id);
            })
            ->when($this->test_scenario_id, function($query) {
                $query->where('tc_test_scenario_id', $this->test_scenario_id);
            })
            ->when($this->priority, function($query) {
                $query->where('tc_priority', $this->priority);
            })
            ->when($this->testing_type, function($query) {
                $query->where('tc_testing_type', $this->testing_type);
            })
            ->where('tc_status', $status)
            ->get(['id', 'tc_name', 'tc_description', 'tc_status']);
    }

    public function hideTestCaseDataModel()
    {
        $this->showDataModel = false;
        $this->testCaseData = [];
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
        $this->getTestCaseStatusCounts(); // Update chart data after filter change
        $this->dispatch('test-case-status-chart-updated', $this->testCaseStatusCounts);
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
        $this->getTestCaseStatusCounts(); // Update chart data after filter change
        $this->dispatch('test-case-status-chart-updated', $this->testCaseStatusCounts);
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
        $this->getTestCaseStatusCounts(); // Update chart data after filter change
        $this->dispatch('test-case-status-chart-updated', $this->testCaseStatusCounts);
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
        $this->getTestCaseStatusCounts(); // Update chart data after filter change
        $this->dispatch('test-case-status-chart-updated', $this->testCaseStatusCounts);
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
    public $priority = null;

    public function updatedPriority()
    {
        if ($this->priority == 'all') {
            $this->priority = null;
        }
        $this->getTestCaseStatusCounts(); // Update chart data after filter change
        $this->dispatch('test-case-status-chart-updated', $this->testCaseStatusCounts);
    }

    // filter: test case type field data handling
    public $testing_type = null;

    public function updatedTestingType()
    {
        if ($this->testing_type == 'all') {
            $this->testing_type = null;
        }
        $this->getTestCaseStatusCounts(); // Update chart data after filter change
        $this->dispatch('test-case-status-chart-updated', $this->testCaseStatusCounts);
    }

    public function clearFilters()
    {
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->test_scenario_id = null;
        $this->priority = null;
        $this->testing_type = null;

        $this->updateBuildsList();
        $this->getTestCaseStatusCounts(); // Update chart data after clearing filters
        $this->dispatch('test-case-status-chart-updated', $this->testCaseStatusCounts);
    }

    public function render()
    {
        return view('livewire.components.dashboard.charts.test-case.test-case-status-chart');
    }
}
