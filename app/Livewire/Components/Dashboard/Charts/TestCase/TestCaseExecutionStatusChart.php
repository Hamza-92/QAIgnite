<?php

namespace App\Livewire\Components\Dashboard\Charts\TestCase;

use App\Models\Build;
use App\Models\TestCycle;
use Livewire\Attributes\On;
use Livewire\Component;
use function Laravel\Prompts\alert;

class TestCaseExecutionStatusChart extends Component
{
    public $cycles;
    public $cycleNames;
    public $passedCounts;
    public $failedCounts;
    public $notExecutedCounts;
    public $tableData = null;

    public function mount()
    {
        $this->refreshData();
        $this->updateBuildsList();
        $this->updateCyclesList();
    }

    public function refreshData()
    {
        $this->cycles = TestCycle::withCount([
            'testCases as passed_count' => fn ($q) => $q->where('status', 'Passed'),
            'testCases as failed_count' => fn ($q) => $q->where('status', 'Failed'),
            'testCases as not_executed_count' => fn ($q) => $q->where('status', 'Not Executed'),
        ])
            ->when($this->build_id !== null, function ($query) {
                $query->where('build_id', $this->build_id);
            })
            ->when($this->cycle_id !== null, function ($query) {
                $query->where('id', $this->cycle_id);
            })
            ->orderBy('created_at', 'desc')
            ->limit(10)
            ->get();
        $this->passedCounts = $this->cycles->pluck('passed_count')->toArray();
        $this->failedCounts = $this->cycles->pluck('failed_count')->toArray();
        $this->notExecutedCounts = $this->cycles->pluck('not_executed_count')->toArray();
        $this->cycleNames = $this->cycles->pluck('name')->toArray();

    }

    // Filter: build field data handling
    public $builds;
    public $build_id;

    public function updatedBuildId()
    {
        if ($this->build_id == 'all') {
            $this->build_id = null;
        }
        $this->updateCyclesList();
        $this->refreshData();
        $this->dispatch('chart-updated', [
            'passedCounts' => $this->passedCounts,
            'failedCounts' => $this->failedCounts,
            'notExecutedCounts' => $this->notExecutedCounts,
            'cycleNames' => $this->cycleNames,
        ]);
    }

    public function updateBuildsList()
    {
        $this->builds = Build::where('project_id', auth()->user()->default_project)
            ->get(['id', 'name']);

        // Reset dependent fields
        $this->build_id = null;
    }

    // Filter: Cycle ID field data handling
    public $filterCycles;
    public $cycle_id;
    public function updatedCycleId()
    {
        if ($this->cycle_id == 'all') {
            $this->cycle_id = null;
        }
        $this->refreshData();
        $this->dispatch('chart-updated', [
            'passedCounts' => $this->passedCounts,
            'failedCounts' => $this->failedCounts,
            'notExecutedCounts' => $this->notExecutedCounts,
            'cycleNames' => $this->cycleNames,
        ]);
    }

    public function updateCyclesList()
    {
        $this->filterCycles = TestCycle::where('project_id', auth()->user()->default_project)
            ->when($this->build_id, function ($query) {
                $query->where('build_id', $this->build_id);
            })
            ->get(['id', 'name']);

        // Reset dependent fields
        $this->cycle_id = null;
    }

    #[On('showTestCycleDetails')]
    public function showTestCycleDetails($cycleName)
    {
        // $this->js(alert('Test Cycle Details'));
        $this->tableData = TestCycle::where('name', $cycleName)
            ->with(['testCases' => fn ($q) => $q->orderByPivot('created_at', 'desc')])
            ->get()->first();
        // dd($this->tableData);
    }

    public function render()
    {
        return view('livewire.components.dashboard.charts.test-case.test-case-execution-status-chart');
    }
}
