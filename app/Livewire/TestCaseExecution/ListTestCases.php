<?php

namespace App\Livewire\TestCaseExecution;

use App\Models\Module;
use App\Models\TestCase;
use App\Models\TestCaseTestCycle;
use App\Models\TestCycle;
use App\Models\TestScenario;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class ListTestCases extends Component
{
    use WithPagination;

    public $test_cycle;
    public $test_cycle_id;
    // public $test_cases;

    public $total_test_cases;
    public $passed_test_cases;
    public $failed_test_cases;
    public $not_executed_test_cases;

    public function mount($test_cycle_id)
    {
        $this->test_cycle_id = $test_cycle_id;
        $this->test_cycle = TestCycle::where('id', $test_cycle_id)
            ->where('project_id', auth()->user()->default_project)
            ->get()->first();

        if (! $this->test_cycle) {
            Toaster::error('Test cycle not found.');
            $this->redirect(route('test-cycles'), true);
        }
        else{
            $this->updateModulesList();
        $this->updateTestScenariosList();
        $this->getAssignedToUsers();

        $counts = $this->test_cycle->testCases()
            ->select('status', DB::raw('count(*) as count'))
            ->groupBy('status')
            ->pluck('count', 'status');
        // dd($counts);
        $this->passed_test_cases = $counts['Passed'] ?? 0;
        $this->failed_test_cases = $counts['Failed'] ?? 0;
        $this->not_executed_test_cases = $counts['Not Executed'] ?? 0;
        $this->total_test_cases = $this->passed_test_cases + $this->failed_test_cases + $this->not_executed_test_cases;
        }


    }

    // Filter: module field data handling
    public $modules;
    public $module_id;
    public function updatedModuleId()
    {
        if ($this->module_id == 'all') {
            $this->module_id = null;
        }

        $this->updateTestScenariosList();
    }
    public function updateModulesList()
    {
        $this->modules = Module::where('project_id', auth()->user()->default_project)
            ->get(['id', 'module_name']);

        $this->module_id = null;
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
        $this->resetPage();
    }
    public function updateTestScenariosList()
    {
        $this->test_scenarios = TestScenario::where('ts_project_id', auth()->user()->default_project)
            ->where('ts_module_id', $this->module_id)
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

    // filter: execution type field data handling
    public $execution_type = null;
    public function updatedExecutionType()
    {
        if ($this->execution_type == 'all') {
            $this->execution_type = null;
        }
        $this->resetPage();
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

    public function clearFilter()
    {
        $this->module_id = null;
        $this->test_scenario_id = null;
        $this->status = null;
        $this->execution_type = null;
        $this->assigned_to = null;
        $this->search = '';
        $this->resetPage();

        $this->updateModulesList();
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
    public function render()
    {
        $test_cases = TestCase::with([
            'testCycles' => function ($q) {
                $q->where('test_cycle_id', $this->test_cycle->id);
            },
            'test_scenario:id,ts_name',
            'assigned_to:id,username',
            'build:id,name'
        ])
            ->whereHas('testCycles', function ($q) {
                $q->where('test_cycle_id', $this->test_cycle->id);
            })
            ->when($this->module_id, function ($q) {
                $q->where('tc_module_id', $this->module_id);
            })
            ->when($this->test_scenario_id, function ($q) {
                $q->where('tc_test_scenario_id', $this->test_scenario_id);
            })
            ->when($this->execution_type, function ($q) {
                $q->where('tc_execution_type', $this->execution_type);
            })
            ->when($this->assigned_to, function ($q) {
                $q->where('tc_assigned_to', $this->assigned_to);
            })
            // ->when($this->module_id, function($q) {
            //     $q->where('tc_module_id', $this->module_id);
            // })
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        // dd(
        //     $test_cases
        // );

        return view('livewire.test-case-execution.list-test-cases', compact('test_cases'));
    }
}
