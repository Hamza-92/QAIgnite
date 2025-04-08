<?php

namespace App\Livewire\Defect;

use App\Models\Attachment;
use App\Models\Build;
use App\Models\Comment;
use App\Models\Defect;
use App\Models\DefectVersion;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestCase;
use App\Models\TestScenario;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class EditDefect extends Component
{
    use WithFileUploads;
    public $defect;
    public $defect_id;
    public $defect_name;
    public $defect_description;
    public $defect_status;
    public $defect_type;
    public $defect_priority;
    public $defect_severity;
    public $defect_environment;
    public $defect_attachments;
    public $defect_steps_to_reproduce;
    public $defect_actual_result;
    public $defect_expected_result;
    public $defect_project_id;
    public $defect_build_id;
    public $defect_module_id;
    public $defect_requirement_id;
    public $defect_test_scenario_id;
    public $defect_test_case_id;
    public $defect_created_by;
    public $defect_assigned_to;
    public $comment;

    public function mount($defect_id)
    {
        $this->defect_id = $defect_id;
        $this->defect = Defect::with('comments')
            ->where('id', $this->defect_id)
            ->where('def_project_id', auth()->user()->default_project)
            ->first();
        if (! $this->defect) {
            return $this->redirect(route('defects'), true);
        }
        $this->defect_name = $this->defect->def_name;
        $this->defect_description = $this->defect->def_description;
        $this->defect_status = $this->defect->def_status;
        $this->defect_type = $this->defect->def_type;
        $this->defect_priority = $this->defect->def_priority;
        $this->defect_severity = $this->defect->def_severity;
        $this->defect_environment = $this->defect->def_environment;
        $this->defect_steps_to_reproduce = $this->defect->def_steps_to_reproduce;
        $this->defect_actual_result = $this->defect->def_actual_result;
        $this->defect_expected_result = $this->defect->def_expected_result;
        $this->defect_project_id = $this->defect->def_project_id;
        $this->defect_build_id = $this->defect->def_build_id;
        $this->defect_module_id = $this->defect->def_module_id;
        $this->defect_requirement_id = $this->defect->def_requirement_id;
        $this->defect_test_scenario_id = $this->defect->def_test_scenario_id;
        $this->defect_test_case_id = $this->defect->def_test_case_id;
        $this->defect_created_by = $this->defect->def_created_by;
        $this->assigned_to = $this->defect->def_assigned_to;
        $this->defect_attachments = $this->defect->def_attachments;
        $this->comment = '';


        $this->form_selected_build_name = $this->defect->build->name ?? null;
        $this->form_selected_module_name = $this->defect->module->module_name ?? null;
        $this->form_selected_requirement_name = $this->defect->requirement->requirement_title ?? null;
        $this->form_selected_test_scenario_name = $this->defect->testScenario->ts_name ?? null;
        $this->form_selected_test_case_name = $this->defect->testCase->tc_name ?? null;
        $this->form_search_build = null;
        $this->form_search_module = null;
        $this->form_search_requirement = null;
        $this->form_search_test_scenario = null;
        $this->form_search_test_case = null;
        $this->form_builds = [];
        $this->form_modules = [];
        $this->form_requirements = [];
        $this->form_test_scenarios = [];
        $this->form_test_cases = [];

        $this->loadFormBuilds();
        $this->loadFormModules();
        $this->loadFormRequirements();
        $this->loadFormTestScenarios();
        $this->loadFormTestCases();
    }

    // Return rules for validation
    public function rules()
    {
        return [
            'defect_name' => 'required|string|min:3|max:255|unique:defects,def_name,'.($this->defect->id ?? 'NULL').',id',
            'defect_description' => 'required|string',
            'defect_status' => 'required|in:open,closed,fixed,re-open,not-a-bug,resolved,deffer,too-limitations,not-reproducible,user-interface,beta,in-progress,to-do,in-review',
            'defect_type' => 'nullable|string|in:functional,ui/ux,cross-browser,cross-platform,field-validation,performance,security,usability,compatibility,integration',
            'defect_priority' => 'required|in:low,medium,high',
            'defect_severity' => 'required|in:minor,major,critical,blocker',
            'defect_environment' => 'nullable|string|in:production,staging,development,testing',
            'defect_steps_to_reproduce' => 'nullable|string',
            'defect_actual_result' => 'nullable|string',
            'defect_expected_result' => 'nullable|string',
            'defect_project_id' => 'required|exists:projects,id',
            'defect_build_id' => 'nullable|exists:builds,id',
            'defect_module_id' => 'nullable|exists:modules,id',
            'defect_requirement_id' => 'nullable|exists:requirements,id',
            'defect_test_scenario_id' => 'nullable|exists:test_scenarios,id',
            'defect_test_case_id' => 'nullable|exists:test_cases,id',
            'defect_assigned_to' => 'nullable|exists:users,id',
            'defect_attachments' => 'nullable|array',
            'defect_created_by' => 'required|exists:users,id',
            'uploadedAttachments.*' => 'file|max:61440|mimes:gif,jpg,jpeg,png,pdf,docx,csv,xls,ppt,mp4,webm,msg,eml',
        ];
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
        if ($this->defect_build_id === $build['id']) {
            return;
        }
        $this->defect_build_id = $build['id'];
        $this->form_selected_build_name = $build['name'];

        $this->resetModuleID();
    }

    public function resetBuildID()
    {
        $this->defect_build_id = null;
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
            ->where('build_id', $this->defect_build_id)
            ->where('project_id', auth()->user()->default_project)
            ->get(['id', 'module_name']);
    }

    public function updatedFormSearchModule()
    {
        $this->loadFormModules();
    }

    public function assignModuleID($module)
    {
        $this->defect_module_id = $module['id'];
        $this->form_selected_module_name = $module['module_name'];

        $this->resetRequirementID();
    }

    public function resetModuleID()
    {
        $this->defect_module_id = null;
        $this->form_selected_module_name = null;
        $this->loadFormModules();

        $this->resetRequirementID();
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
            ->where('build_id', $this->defect_build_id)
            ->where('module_id', $this->defect_module_id)
            ->get(['id', 'requirement_title']);
    }

    public function updatedFormSearchRequirement()
    {
        $this->loadFormRequirements();
    }

    public function assignRequirementID($requirement)
    {
        $this->defect_requirement_id = $requirement['id'];
        $this->form_selected_requirement_name = $requirement['requirement_title'];

        $this->resetTestScenarioID();
    }
    public function resetRequirementID()
    {
        $this->defect_requirement_id = null;
        $this->form_selected_requirement_name = null;
        $this->loadFormRequirements();

        $this->resetTestScenarioID();
    }

    /* -- Form module field data halndling -- */
    public $form_test_scenarios;
    public $form_search_test_scenario;
    public $form_selected_test_scenario_name;

    public function loadFormTestScenarios()
    {
        $this->form_test_scenarios = TestScenario::when($this->form_search_test_scenario, function ($query) {
            $query->where('ts_name', 'like', "%{$this->form_search_test_scenario}%");
        })
            ->where('ts_project_id', auth()->user()->default_project)
            ->where('ts_build_id', $this->defect_build_id)
            ->where('ts_module_id', $this->defect_module_id)
            ->where('ts_requirement_id', $this->defect_requirement_id)
            ->get(['id', 'ts_name']);
    }

    public function updatedFormSearchTestScenario()
    {
        $this->loadFormTestScenarios();
    }

    public function assignTestScenarioID($test_scenario)
    {
        $this->defect_test_scenario_id = $test_scenario['id'];
        $this->form_selected_test_scenario_name = $test_scenario['ts_name'];

        $this->resetTestCaseID();
    }
    public function resetTestScenarioID()
    {
        $this->defect_test_scenario_id = null;
        $this->form_selected_test_scenario_name = null;
        $this->loadFormTestScenarios();

        $this->resetTestCaseID();
    }

    /* -- Form module field data halndling -- */
    public $form_test_cases;
    public $form_search_test_case;
    public $form_selected_test_case_name;

    public function loadFormTestCases()
    {
        $this->form_test_cases = TestCase::when($this->form_selected_test_case_name, function ($query) {
            $query->where('tc_name', 'like', "%{$this->form_selected_test_case_name}%");
        })
            ->where('tc_project_id', auth()->user()->default_project)
            ->where('tc_build_id', $this->defect_build_id)
            ->where('tc_module_id', $this->defect_module_id)
            ->where('tc_requirement_id', $this->defect_requirement_id)
            ->where('tc_test_scenario_id', $this->defect_test_scenario_id)
            ->get(['id', 'tc_name']);
    }

    public function updatedFormSearchTestCase()
    {
        $this->loadFormTestCases();
    }

    public function assignTestCaseID($test_scenario)
    {
        $this->defect_test_case_id = $test_scenario['id'];
        $this->form_selected_test_case_name = $test_scenario['tc_name'];
    }
    public function resetTestCaseID()
    {
        $this->defect_test_case_id = null;
        $this->form_selected_test_case_name = null;
        $this->loadFormTestCases();
    }

    public function updatedDefectType()
    {
        $this->defect_type = trim($this->defect_type) === '' ? null : $this->defect_type;
    }

    // Defect Status
    public function updatedDefectStatus()
    {
        if ($this->defect_status == '') {
            $this->defect_status = null;
        }
    }
    // Defect Priority
    public function updatedDefectPriority()
    {
        if ($this->defect_priority == '') {
            $this->defect_priority = null;
        }
    }
    // Defect Severity
    public function updatedDefectSeverity()
    {
        if ($this->defect_severity == '') {
            $this->defect_severity = null;
        }
    }
    // Defect Environment
    public function updatedDefectEnvironment()
    {
        if ($this->defect_environment == '') {
            $this->defect_environment = null;
        }
    }
    // Defect Assigned To
    public function updatedDefectAssignedTo()
    {
        if ($this->defect_assigned_to == '') {
            $this->defect_assigned_to = null;
        }
    }

    // Attachments
    #[Rule(['uploadedAttachments.*' => 'file|max:61440|mimes:gif,jpg,jpeg,png,pdf,docx,csv,xls,ppt,mp4,webm,msg,eml'])]
    public array $tempAttachments;
    public array $uploadedAttachments;
    public function updatedTempAttachments()
    {
        foreach ($this->tempAttachments as $tempAttachment) {
            $this->uploadedAttachments[] = $tempAttachment;
        }
        $this->temp_attachments = [];
    }
    public function removeAttachment($index)
    {
        if (isset($this->uploadedAttachments[$index])) {
            $this->uploadedAttachments[$index]->delete();
            unset($this->uploadedAttachments[$index]);
            $this->uploadedAttachments = array_values($this->uploadedAttachments);
        }
    }

    public function save()
    {
        $this->validate($this->rules());
        // Upload attachments
        if ($this->uploadedAttachments) {
            foreach ($this->uploadedAttachments as $attachment) {
                $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                $extension = $attachment->getClientOriginalExtension();
                $timestamp = now()->timestamp;
                $customName = "{$filename}_{$timestamp}.{$extension}";
                $path = $attachment->storeAs('attachments/defects', $customName);
                $attachment = Attachment::create([
                    'filename' => $customName,
                    'file_type' => $attachment->getClientMimeType(),
                    'file_path' => $path,
                    'project_id' => $this->defect_project_id,
                ]);
                $this->defect_attachments[] = $attachment->id;
            }
        }
        $this->defect->update([
            'def_name' => $this->defect_name,
            'def_description' => $this->defect_description,
            'def_status' => $this->defect_status,
            'def_type' => $this->defect_type,
            'def_priority' => $this->defect_priority,
            'def_severity' => $this->defect_severity,
            'def_environment' => $this->defect_environment,
            'def_steps_to_reproduce' => $this->defect_steps_to_reproduce,
            'def_actual_result' => $this->defect_actual_result,
            'def_expected_result' => $this->defect_expected_result,
            'def_project_id' => auth()->user()->default_project,
            'def_build_id' => $this->defect_build_id,
            'def_module_id' => $this->defect_module_id,
            'def_requirement_id' => $this->defect_requirement_id,
            'def_test_scenario_id' => $this->defect_test_scenario_id,
            'def_test_case_id' => $this->defect_test_case_id,
            'def_created_by' => auth()->user()->id,
            'def_assigned_to' => $this->defect_assigned_to,
            'def_attachments' => $this->defect_attachments,
        ]);

        DefectVersion::create([
            'defect_id' => $this->defect->id,
            'def_name' => $this->defect_name,
            'def_description' => $this->defect_description,
            'def_status' => $this->defect_status,
            'def_type' => $this->defect_type,
            'def_priority' => $this->defect_priority,
            'def_severity' => $this->defect_severity,
            'def_environment' => $this->defect_environment,
            'def_steps_to_reproduce' => $this->defect_steps_to_reproduce,
            'def_actual_result' => $this->defect_actual_result,
            'def_expected_result' => $this->defect_expected_result,
            'def_project_id' => auth()->user()->default_project,
            'def_build_id' => $this->defect_build_id,
            'def_module_id' => $this->defect_module_id,
            'def_requirement_id' => $this->defect_requirement_id,
            'def_test_scenario_id' => $this->defect_test_scenario_id,
            'def_test_case_id' => $this->defect_test_case_id,
            'def_created_by' => auth()->user()->id,
            'def_assigned_to' => $this->defect_assigned_to,
            'def_attachments' => $this->defect_attachments,
        ]);

        // Store comments
        Comment::create([
            'comment' => auth()->user()->username.' updated defect.',
            'defect_id' => $this->defect->id,
            'user_id' => auth()->user()->id
        ]);
        if ($this->comment) {
            Comment::create([
                'comment' => $this->comment,
                'defect_id' => $this->defect->id,
                'user_id' => auth()->user()->id
            ]);
        }
        Toaster::success('Defect updated successfully.');
        $this->redirect(route('defects'), true);
    }
    public function render()
    {
        $defect_versions = DefectVersion::with(['build', 'module', 'requirement', 'testScenario', 'testCase', 'createdBy', 'assignedTo'])
            ->where('defect_id', $this->defect_id)
            ->where('def_project_id', auth()->user()->default_project)
            ->orderBy('created_at', 'desc')
            ->get()->map(function ($version) {
                $version->attachments = Attachment::whereIn('id', $version->def_attachments)->pluck('filename');
                return $version;
            });

        $attachments = Attachment::whereIn('id', $this->defect->def_attachments)->get();

        return view('livewire.defect.edit-defect', compact(['attachments', 'defect_versions']));
    }
}
