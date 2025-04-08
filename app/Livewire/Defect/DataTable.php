<?php

namespace App\Livewire\Defect;

use App\Models\Build;
use App\Models\Defect;
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

    public function mount()
    {
        $this->updateBuildsList();
        $this->updateModulesList();
        $this->updateRequirementsList();
        $this->updateTestScenariosList();
        $this->updateTestCasesList();

        $this->getCreatedByUsers();
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
        $this->resetPage();
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
        $this->resetPage();
    }

    // Filter: status field data handling
    public $defect_status;
    public function updatedDefectStatus()
    {
        if ($this->defect_status == 'all') {
            $this->defect_status = null;
        }
        $this->resetPage();
    }

    // Filter: severity field data handling
    public $defect_severity;
    public function updatedDefectSeverity()
    {
        if ($this->defect_severity == 'all') {
            $this->defect_severity = null;
        }
        $this->resetPage();
    }

    // Filter: priority field data handling
    public $defect_priority;
    public function updatedDefectPriority()
    {
        if ($this->defect_priority == 'all') {
            $this->defect_priority = null;
        }
        $this->resetPage();
    }

    // Filter: defect environment field data handling
    public $defect_environment;
    public function updatedDefectEnvironment()
    {
        if ($this->defect_environment == 'all') {
            $this->defect_environment = null;
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
        $this->created_by_users = User::whereHas('created_defects', function ($query) {
            $query->where('def_project_id', auth()->user()->default_project);
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
        $this->defect_environment = null;
        $this->created_by = null;
        $this->assigned_to = null;

        // Reset search and pagination
        $this->search = '';
        $this->resetPage();
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

    #[On('refreshDefectList')]
    public function refreshDefectList()
    {
        $this->dispatch('refreshTable');
    }

    public function editDefect($defect_id)
    {
        $this->dispatch('editDefect', $defect_id);
    }

    public function deleteDefect($defect_id)
    {
        Defect::where('id', $defect_id)
            ->where('def_project_id', auth()->user()->default_project)
            ->delete();
        Toaster::success('Defect deleted successfully.');

        $this->resetPage();
    }

    public function render()
    {
        $defects = Defect::when($this->search, function ($query) {
                $query->where(function ($query) {
                    $searchPattern = '%' . implode('%', str_split($this->search)) . '%';
                    $query->where('def_name', 'like', $searchPattern)
                          ->orWhere('def_description', 'like', $searchPattern);
                });
            })
            ->where('def_project_id', auth()->user()->default_project)
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
            ->when($this->defect_environment, function ($query) {
                $query->where('def_environment', $this->defect_environment);
            })
            ->when($this->created_by, function ($query) {
                $query->where('def_created_by', $this->created_by);
            })
            ->when($this->assigned_to, function ($query) {
                $query->where('def_assigned_to', $this->assigned_to);
            })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);
        return view('livewire.defect.data-table', compact('defects'));
    }
}
