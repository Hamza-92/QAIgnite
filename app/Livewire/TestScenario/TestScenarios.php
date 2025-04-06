<?php

namespace App\Livewire\TestScenario;

use App\Models\Build;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestScenario;
use Livewire\Attributes\On;
use Livewire\Component;
use Masmerise\Toaster\Toaster;
use phpDocumentor\Reflection\Types\Boolean;

class TestScenarios extends Component
{
    public $test_scenario;
    public $ts_name;
    public $ts_description;
    public $project_id;
    public $build_id;
    public $module_id;
    public $requirement_id;
    public $created_by;

    protected function rules()
    {
        return [
            'ts_name' => 'required|string|min:3|max:255|unique:test_scenarios,ts_name,'.($this->test_scenario->id ?? 'null'),
            'ts_description' => 'required|string|min:3|max:1500',
            'project_id' => 'required|integer',
            'build_id' => 'nullable|sometimes|integer',
            'module_id' => 'nullable|sometimes|integer',
            'requirement_id' => 'nullable|sometimes|integer',
        ];
    }

    /*
    ===============
    Form handling
    ===============
    */

    /* -- Form Controller -- */
    public bool $create;
    public bool $edit;

    public function resetForm()
    {
        $this->create = false;
        $this->edit = false;

        $this->initializeValues();
    }

    /* -- Form build field data halndling -- */
    public $form_builds; // List of builds
    public $form_search_build; // Search query
    public $form_selected_build_name; // Selected build name (work as a label)

    public function loadFormBuilds()
    {
        $this->form_builds = Build::when($this->form_search_build, function ($query) {
            $query->where('name', 'like', "%{$this->form_search_build}%");
        })
            ->where('project_id', auth()->user()->default_project)
            ->get(['id', 'name']);
    }

    public function updatedFormSearchBuild()
    {
        $this->loadFormBuilds();
    }

    public function assignBuildID($build)
    {
        if ($this->build_id === $build['id']) {
            return;
        }
        $this->build_id = $build['id'];
        $this->form_selected_build_name = $build['name'];

        $this->resetModuleID();
    }

    public function resetBuildID()
    {
        $this->build_id = null;
        $this->form_selected_build_name = null;
        $this->resetModuleID();
    }

    /* -- Form module field data halndling -- */
    public $form_modules;
    public $form_search_module;
    public $form_selected_module_name;

    public function loadFormModules()
    {
        $this->form_modules = Module::when($this->form_search_module, function ($query) {
            $query->where('module_name', 'like', "%{$this->form_search_module}%");
        })
            ->where('build_id', $this->build_id)
            ->where('project_id', auth()->user()->default_project)
            ->get(['id', 'module_name']);
    }

    public function updatedFormSearchModule()
    {
        $this->loadFormModules();
    }

    public function assignModuleID($module)
    {
        $this->module_id = $module['id'];
        $this->form_selected_module_name = $module['module_name'];

        $this->resetRequirementID();
    }

    public function resetModuleID()
    {
        $this->module_id = null;
        $this->form_selected_module_name = null;
        $this->loadFormModules();

        $this->resetRequirementID();
        $this->loadFormRequirements();
    }

    /* -- Form module field data halndling -- */
    public $form_requirements;
    public $form_search_requirement;
    public $form_selected_requirement_name;

    public function loadFormRequirements()
    {
        $this->form_requirements = Requirement::when($this->form_search_requirement, function ($query) {
            $query->where('requirement_title', 'like', "%{$this->form_search_requirement}%");
        })
            ->where('project_id', auth()->user()->default_project)
            ->where('build_id', $this->build_id)
            ->where('module_id', $this->module_id)
            ->get(['id', 'requirement_title']);
        // dd($this->form_requirements);
    }

    public function updatedFormSearchRequirement()
    {
        $this->loadFormRequirements();
    }

    public function assignRequirementID($requirement)
    {
        $this->requirement_id = $requirement['id'];
        $this->form_selected_requirement_name = $requirement['requirement_title'];
    }
    public function resetRequirementID()
    {
        $this->requirement_id = null;
        $this->form_selected_requirement_name = null;
    }

    public function initializeValues()
    {
        $this->test_scenario = null;
        $this->ts_name = null;
        $this->ts_description = null;
        $this->project_id = auth()->user()->default_project;
        $this->build_id = null;
        $this->module_id = null;
        $this->requirement_id = null;
        $this->form_builds = [];
        $this->form_search_build = null;
        $this->form_selected_build_name = null;
        $this->form_modules = [];
        $this->form_search_module = null;
        $this->form_selected_module_name = null;
        $this->form_requirements = [];
        $this->form_search_requirement = '';
        $this->form_selected_requirement_name = null;
        $this->loadFormBuilds();
        $this->loadFormModules();
        $this->loadFormRequirements();
    }

    public function mount()
    {
        $this->initializeValues();
        $this->create = false;
        $this->edit = false;
    }

    #[On('editTestScenario')]
    public function edit($id)
    {
        $this->test_scenario = TestScenario::find($id);
        if ($this->test_scenario) {
            $this->ts_name = $this->test_scenario->ts_name;
            $this->ts_description = $this->test_scenario->ts_description;
            $this->project_id = $this->test_scenario->ts_project_id;
            $this->build_id = $this->test_scenario->ts_build_id;
            $this->module_id = $this->test_scenario->ts_module_id;
            $this->requirement_id = $this->test_scenario->ts_requirement_id;

            // Form handling
            $this->create = false;
            $this->edit = true;

            // Form build field data handling
            $this->form_builds = [];
            $this->form_search_build = null;
            $this->form_selected_build_name = $this->test_scenario->ts_build_id ? Build::find($this->test_scenario->ts_build_id)->name : null;
            $this->loadFormBuilds();

            // Form module field data handling
            $this->form_modules = [];
            $this->form_search_module = null;
            $this->form_selected_module_name = $this->test_scenario->ts_module_id ? Module::find($this->test_scenario->module_id)->ts_module_name : null;
            $this->loadFormModules();

            // Form requirement field data handling
            $this->form_requirements = [];
            $this->form_search_requirement = '';
            $this->form_selected_requirement_name = $this->test_scenario->ts_requirement_id ? Requirement::find($this->test_scenario->ts_requirement_id)->requirement_title : null;
            $this->loadFormRequirements();
        } else {
            Toaster::error('Test scenario not found');
        }
    }

    public function save()
    {
        $this->validate($this->rules());
        if ($this->create) {
            TestScenario::create([
                'ts_name' => $this->ts_name,
                'ts_description' => $this->ts_description,
                'ts_project_id' => $this->project_id,
                'ts_build_id' => $this->build_id,
                'ts_module_id' => $this->module_id,
                'ts_requirement_id' => $this->requirement_id,
                'ts_created_by' => auth()->user()->id
            ]);
            Toaster::success('Test scenario created successfully');
        } else if ($this->edit) {
            $this->test_scenario->update([
                'ts_name' => $this->ts_name,
                'ts_description' => $this->ts_description,
                'ts_project_id' => $this->project_id,
                'ts_build_id' => $this->build_id,
                'ts_module_id' => $this->module_id,
                'ts_requirement_id' => $this->requirement_id,
                'ts_created_by' => auth()->user()->id
            ]);
            Toaster::success('Test scenario updated successfully');
        }
        $this->resetForm();
        $this->dispatch('test_scenario_saved');
    }

    public function render()
    {
        return view('livewire.test-scenario.test-scenarios');
    }
}
