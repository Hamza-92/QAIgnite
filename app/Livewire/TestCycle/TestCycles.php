<?php

namespace App\Livewire\TestCycle;

use App\Models\TestCycle;
use Livewire\Attributes\On;
use Livewire\Component;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class TestCycles extends Component
{
    use WithPagination;
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

    #[On('notify')]
    public function notify($message)
    {
        Toaster::info($message);
    }

    public function cloneTestCycle($id)
    {
        $testCycle = TestCycle::with(['assignees', 'testCases'])->find($id);

        if (! $testCycle) {
            Toaster::error('Test Cycle not found.');
            return;
        }

        // Clone the test cycle
        $newTestCycle = $testCycle->replicate();
        $newTestCycle->name = $this->generateUniqueName($testCycle->name);
        $newTestCycle->status = 'In Progress';
        $newTestCycle->created_by = auth()->id();
        $newTestCycle->save();

        if ($testCycle->assignees->isNotEmpty()) {
            $newTestCycle->assignees()->attach($testCycle->assignees->pluck('id'));
        }

        if ($testCycle->testCases->isNotEmpty()) {
            foreach ($testCycle->testCases as $testCase) {
                $newTestCycle->testCases()->attach($testCase->id, [
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

        Toaster::success('Test cycle cloned successfully');
    }

    private function generateUniqueName($baseName)
    {
        $counter = 1;
        $uniqueName = $baseName;

        while (TestCycle::where('name', $uniqueName)->exists()) {
            $uniqueName = $baseName.' ('.$counter.')';
            $counter++;
        }

        return $uniqueName;
    }

    public function deleteTestCycle($id)
    {
        $testCycle = TestCycle::find($id);

        if ($testCycle) {
            $testCycle->delete();
            Toaster::success('Test cycle deleted');
        } else {
            Toaster::error('Test Cycle not found.');
        }
    }
    public function render()
    {
        $test_cycles = TestCycle::with(['build', 'assignees', 'testCases'])
            ->when($this->search, function ($query) {
                $query->where(function ($query) {
                    $searchPattern = '%'.implode('%', str_split($this->search)).'%';
                    $query->where('name', 'like', $searchPattern);
                });
            })
            ->where('project_id', auth()->user()->default_project)
            ->orderBy($this->sortBy, $this->sortDir)
            ->paginate($this->perPage);

        return view('livewire.test-cycle.test-cycles', ['test_cycles' => $test_cycles]);
    }
}
