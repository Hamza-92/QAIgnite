<?php

namespace App\Livewire\Components\Dashboard\InfoCard;

use App\Models\Build;
use App\Models\Defect;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestCase;
use App\Models\TestScenario;
use App\Models\User;
use Livewire\Component;

class DefectCard extends Component
{
    public function mount()
    {
        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();
        $this->updateTestCasesList();
        $this->getAssignedToUsers();
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
        $this->updateTestCasesList();
    }
    public function updateTestScenariosList()
    {
        $this->test_scenarios = TestScenario::where('ts_project_id', auth()->user()->default_project)
            ->where('ts_build_id', $this->build_id)
            ->where('ts_module_id', $this->module_id)
            ->where('ts_requirement_id', $this->requirement_id)
            ->get(['id', 'ts_name']);

        $this->test_scenario_id = null;

        $this->updateTestCasesList();
    }
    // Filter: test case field data handling
    public $test_cases;
    public $test_case_id;
    public function updatedTestCaseId()
    {
        if($this->test_case_id == 'all') {
            $this->test_case_id = null;
        }
    }
    public function updateTestCasesList()
    {
        $this->test_cases = TestCase::where('tc_project_id', auth()->user()->default_project)
            ->where('tc_build_id', $this->build_id)
            ->where('tc_module_id', $this->module_id)
            ->where('tc_requirement_id', $this->requirement_id)
            ->where('tc_test_scenario_id', $this->test_scenario_id)
            ->get(['id', 'tc_name']);

        $this->test_case_id = null;
    }

    // Filter: defect type field data handling
    public $defect_type;
    public function updatedDefectType()
    {
        if ($this->defect_type == 'all') {
            $this->defect_type = null;
        }
    }

    // Filter: status field data handling
    public $defect_status;
    public function updatedDefectStatus()
    {
        if ($this->defect_status == 'all') {
            $this->defect_status = null;
        }
    }

    // Filter: severity field data handling
    public $defect_severity;
    public function updatedDefectSeverity()
    {
        if ($this->defect_severity == 'all') {
            $this->defect_severity = null;
        }
    }

    // Filter: priority field data handling
    public $defect_priority;
    public function updatedDefectPriority()
    {
        if ($this->defect_priority == 'all') {
            $this->defect_priority = null;
        }
    }

    // Filter: assigned_to field data handling
    public $assigned_to_users;
    public $assigned_to;
    public function updatedAssignedTo()
    {
        if ($this->assigned_to == 'all') {
            $this->assigned_to = null;
        }
    }
    public function getAssignedToUsers()
    {
        $this->assigned_to_users = User::whereHas('assigned_defects', function ($query) {
            $query->where('def_project_id', auth()->user()->default_project);
        })
            ->select('id', 'username')
            ->distinct()
            ->get();
    }

    public function clearFilter() {
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->test_scenario_id = null;
        $this->test_case_id = null;
        $this->defect_type = null;
        $this->defect_status = null;
        $this->defect_severity = null;
        $this->defect_priority = null;
        $this->assigned_to = null;
    }
    public function render()
    {
        $total_defects = Defect::where('def_project_id', auth()->user()->default_project)
            ->when($this->build_id, function ($query) {
                $query->where('def_build_id', $this->build_id);
            })
            ->when($this->module_id, function ($query) {
                $query->where('def_module_id', $this->module_id);
            })
            ->when($this->requirement_id, function ($query) {
                $query->where('def_requirement_id', $this->requirement_id);
            })
            ->when($this->test_scenario_id, function ($query) {
                $query->where('def_test_scenario_id', $this->test_scenario_id);
            })
            ->when($this->test_case_id, function ($query) {
                $query->where('def_test_case_id', $this->test_case_id);
            })
            ->when($this->defect_type, function ($query) {
                $query->where('def_type', $this->defect_type);
            })
            ->when($this->defect_status, function ($query) {
                $query->where('def_status', $this->defect_status);
            })
            ->when($this->defect_severity, function ($query) {
                $query->where('def_severity', $this->defect_severity);
            })
            ->when($this->defect_priority, function ($query) {
                $query->where('def_priority', $this->defect_priority);
            })
            ->count();

        $open_defects = Defect::where('def_project_id', auth()->user()->default_project)
            ->when($this->build_id, function ($query) {
                $query->where('def_build_id', $this->build_id);
            })
            ->when($this->module_id, function ($query) {
                $query->where('def_module_id', $this->module_id);
            })
            ->when($this->requirement_id, function ($query) {
                $query->where('def_requirement_id', $this->requirement_id);
            })
            ->when($this->test_scenario_id, function ($query) {
                $query->where('def_test_scenario_id', $this->test_scenario_id);
            })
            ->when($this->test_case_id, function ($query) {
                $query->where('def_test_case_id', $this->test_case_id);
            })
            ->when($this->defect_type, function ($query) {
                $query->where('def_type', $this->defect_type);
            })
            ->when($this->defect_status, function ($query) {
                $query->where('def_status', $this->defect_status);
            })
            ->when($this->defect_severity, function ($query) {
                $query->where('def_severity', $this->defect_severity);
            })
            ->when($this->defect_priority, function ($query) {
                $query->where('def_priority', $this->defect_priority);
            })
            ->whereNotIn('def_status', ['closed', 'resolved', 'rejected', 'fixed', 'duplicate', 'not-a-bug'])
            ->count();
        return view('livewire.components.dashboard.info-card.defect-card', compact('total_defects', 'open_defects'));
    }
}
