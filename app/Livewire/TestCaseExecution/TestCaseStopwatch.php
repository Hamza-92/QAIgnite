<?php

namespace App\Livewire\TestCaseExecution;

use Livewire\Component;
use App\Models\TestCaseExecutionSession;
use Illuminate\Support\Facades\Auth;

class TestCaseStopwatch extends Component
{
    public $testCaseId;
    public $session;
    public $running = false;
    public $elapsed = 0;

    public function mount($testCaseId)
    {
        $this->testCaseId = $testCaseId;
        $this->session = TestCaseExecutionSession::firstOrCreate([
            'user_id' => Auth::id(),
            'test_case_id' => $this->testCaseId,
        ]);

        $this->running = $this->session->is_running;
    }

    public function start()
    {
        $this->session->update([
            'started_at' => now(),
            'paused_at' => null,
            'total_paused_seconds' => 0,
            'is_running' => true,
        ]);
        $this->running = true;
    }

    public function pause()
    {
        $this->session->update([
            'paused_at' => now(),
            'is_running' => false,
        ]);
        $this->running = false;
    }

    public function resume()
    {
        if ($this->session->paused_at) {
            $pausedDuration = now()->diffInSeconds($this->session->paused_at);
            $this->session->update([
                'total_paused_seconds' => $this->session->total_paused_seconds + $pausedDuration,
                'paused_at' => null,
                'is_running' => true,
            ]);
        }
        $this->running = true;
    }

    public function elapsedTime()
    {
        if (!$this->session->started_at) {
            return 0; // If started_at is null, return 0 seconds
        }

        // If the timer is running, calculate the elapsed time
        if ($this->session->is_running) {
            return now()->diffInSeconds($this->session->started_at) - $this->session->total_paused_seconds;
        }

        // If the timer is paused, calculate the elapsed time from started_at to paused_at
        if ($this->session->paused_at) {
            return $this->session->paused_at->diffInSeconds($this->session->started_at) - $this->session->total_paused_seconds;
        }

        return 0; // Default return if neither running nor paused
    }


    public function render()
    {
        $this->elapsed = $this->elapsedTime();
        return view('livewire.test-case-execution.test-case-stopwatch', [
            'formatted' => gmdate('H:i:s', max(0, $this->elapsed)),
        ]);
    }
}
