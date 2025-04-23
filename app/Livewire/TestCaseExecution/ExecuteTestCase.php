<?php

namespace App\Livewire\TestCaseExecution;

use App\Models\Defect;
use App\Models\TestCase;
use App\Models\TestCaseExecution;
use App\Models\TestCaseExecutionSession;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class ExecuteTestCase extends Component
{
    public $test_cycle_id;
    public $test_case_id;
    public $test_case_executions;
    public $test_case;

    public $defect_detail = null;
    public $defect_detail_model = false;

    public $executionSession;
    public $is_running;
    public $elapsedTime = '00:00:00';

    public $status;
    public $comment;
    public $time;

    public function mount($test_cycle_id, $test_case_id)
    {
        $this->test_cycle_id = $test_cycle_id;
        $this->test_case_id = $test_case_id;

        $this->test_case = TestCase::where('id', $this->test_case_id)
            ->whereHas('testCycles', function ($q) {
                $q->where('test_cycle_id', $this->test_cycle_id);
            })
            ->where('tc_project_id', auth()->user()->default_project)
            ->get()->first();

        if (! $this->test_case) {
            Toaster::error('Invalid Test Case ID');
            $this->redirect(route('test-case-execution.list', [$this->test_cycle_id]), true);
        } else {
            $this->getExecutions();
            $this->fetchExecutionSession();
        }
    }

    public function fetchExecutionSession()
    {
        $this->executionSession = TestCaseExecutionSession::where('test_case_id', $this->test_case_id)
            ->where('user_id', auth()->user()->id)
            ->get()->first();
        if (! $this->executionSession) {
            $this->executionSession = TestCaseExecutionSession::create([
                'user_id' => auth()->user()->id,
                'test_case_id' => $this->test_case_id,
            ]);
        }
        $this->is_running = $this->executionSession->is_running;
    }

    public function start()
    {
        $this->executionSession->update([
            'started_at' => now(),
            'paused_at' => null,
            'total_paused_seconds' => 0,
            'is_running' => true,
        ]);
        $this->is_running = true;
    }

    public function pause()
    {
        $this->executionSession->update([
            'paused_at' => now(),
            'is_running' => false,
        ]);
        $this->is_running = false;
    }

    public function resume()
    {
        if ($this->executionSession->paused_at) {
            $pausedDuration = $this->executionSession->paused_at->diffInSeconds(now());
            $this->executionSession->update([
                'total_paused_seconds' => $this->executionSession->total_paused_seconds + $pausedDuration,
                'paused_at' => null,
                'is_running' => true,
            ]);
        }
        $this->is_running = true;
    }

    public function elapsedTime()
    {
        if (! $this->executionSession->started_at) {
            return 0;
        }

        if ($this->executionSession->is_running) {
            return $this->executionSession->started_at->diffInSeconds(now()) - $this->executionSession->total_paused_seconds;
        } elseif ($this->executionSession->paused_at) {
            return $this->executionSession->started_at->diffInSeconds($this->executionSession->paused_at) - $this->executionSession->total_paused_seconds;
        }

        return 0;
    }

    public function getExecutions()
    {
        $this->test_case_executions = TestCaseExecution::with('executedBy', 'defect')
            ->where('test_case_id', $this->test_case_id)
            ->where('test_cycle_id', $this->test_cycle_id)
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function updatedStatus() {
        if($this->status == 'select') {
            $this->status = null;
        }
    }

    public function save()
    {
        $this->validate([
            'status' => 'required|string|in:Passed,Failed,Not Executed',
            'comment' => 'nullable|string|min:3|max:1000'
        ]);
        TestCaseExecution::create([
            'test_case_id' => $this->test_case_id,
            'test_cycle_id' => $this->test_cycle_id,
            'executed_by' => auth()->user()->id,
            'status' => $this->status,
            'comment' => $this->comment,
            'execution_time' => $this->elapsedTime(),
        ]);

        $this->test_case->testCycles()->updateExistingPivot($this->test_cycle_id, [
            'status' => $this->status,
        ]);

        // Delete Session
        $this->executionSession->delete();

        // Resets fields
        $this->fetchExecutionSession();
        $this->status = null;
        $this->comment = null;

        $this->getExecutions();

        Toaster::success('Test case executed.');
    }

    public function fetchDefectDetails($defect_id) {
        $this->defect_detail = Defect::with('createdBy', 'comments')->where('id', $defect_id)->first();

        if(! $this->defect_detail) {
            Toaster::error('Defect not found');
            return;
        }

        $this->defect_detail_model = true;
    }

    public function closeModel() {
        $this->defect_detail_model = false;
        $this->defect_detail = null;
    }

    public function render()
    {
        $this->elapsed = $this->elapsedTime();
        return view('livewire.test-case-execution.execute-test-case', [
            'formatted_time' => gmdate('H:i:s', $this->elapsed),
        ]);
    }
}
