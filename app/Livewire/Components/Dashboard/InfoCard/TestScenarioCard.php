<?php

namespace App\Livewire\Components\Dashboard\InfoCard;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestScenario;
use Livewire\Component;

class TestScenarioCard extends Component
{

    // Filter: build field data halndling
    public $builds;
    public $build_id;

    // Filter: module field data halndling
    public $modules;
    public $module_id;

    // Filter: module field data halndling
    public $requirements;
    public $requirement_id;

    public function mount() {
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;

        $this->updateBuildsList();
        $this->updateModulesList();
    }
    public function updatedBuildId()
    {
        if($this->build_id == 'all') {
            $this->build_id = null;
        }
        $this->updateModulesList();
        $this->updateRequirementsList();
    }

    public function updatedModuleId()
    {
        if($this->module_id == 'all') {
            $this->module_id = null;
        }
        $this->updateRequirementsList();
    }

    public function updatedRequirementId()
    {
        if($this->requirement_id == 'all') {
            $this->requirement_id = null;
        }
    }

    public function updateBuildsList()
    {
        $this->builds = Build::where('project_id', auth()->user()->default_project)
            ->get(['id', 'name']);

        // Reset dependent fields
        $this->build_id = null;
        $this->updateModulesList();
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

    public function updateRequirementsList()
    {
        $this->requirements = Requirement::where('project_id', auth()->user()->default_project)
            ->where('build_id', $this->build_id)
            ->where('module_id', $this->module_id)
            ->get(['id', 'requirement_title']);

        $this->requirement_id = null;
    }

    public function render()
    {
        $total_test_scenarios = TestScenario::where('ts_project_id', auth()->user()->default_project)
        ->when($this->build_id, function ($query) {
            return $query->where('ts_build_id', $this->build_id);
        })
        ->when($this->module_id, function ($query) {
            return $query->where('ts_module_id', $this->module_id);
        })
        ->when($this->requirement_id, function ($query) {
            return $query->where('ts_requirement_id', $this->requirement_id);
        })
        ->count();
        return view('livewire.components.dashboard.info-card.test-scenario-card', compact('total_test_scenarios'));
    }
}
