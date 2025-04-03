<?php

namespace App\Livewire\TestScenario;

use App\Models\TestScenario;
use Livewire\Component;

class TsDetail extends Component
{
    public $test_scenario_id;

    public function mount($test_scenario_id) {
        $this->test_scenario_id = $test_scenario_id;
    }

    public function edit() {
        $this->dispatch('editTestScenario', $this->test_scenario_id);
        return redirect()->route('test-scenarios', ['id' => $this->test_scenario_id]);
    }

    public function render()
    {
        $test_scenario = TestScenario::with(['build', 'module', 'createdBy'])
            ->where('id', $this->test_scenario_id)
            ->where('project_id', auth()->user()->default_project)
            ->first();
        // dd($test_scenario);

        return view('livewire.test-scenario.ts-detail', compact(['test_scenario']));
    }
}
