<?php

namespace App\Livewire\TestCase;

use App\Models\Attachment;
use App\Models\Build;
use App\Models\Comment;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\TestCase;
use App\Models\TestCaseVersion;
use App\Models\TestScenario;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Masmerise\Toaster\Toaster;

class EditTestCase extends Component
{
    use WithFileUploads;
    public $test_case;
    public $tc_id;
    public $tc_name;
    public $tc_description;
    public $tc_status;
    public $tc_approval_request;
    public $tc_project_id;
    public $tc_build_id;
    public $tc_module_id;
    public $tc_requirement_id;
    public $tc_test_scenario_id;
    public $tc_testing_type;
    public $tc_estimate_time;
    public $tc_pre_conditions;
    public $tc_detailed_steps;
    public $tc_expected_result;
    public $tc_post_conditions;
    public $tc_execution_type;
    public $tc_priority;
    public $tc_assigned_to;
    public $tc_comment;
    #[Rule(['uploadedAttachments.*' => 'file|max:61440|mimes:gif,jpg,jpeg,png,pdf,docx,csv,xls,ppt,mp4,webm,msg,eml'])]
    public array $tempAttachments;
    public array $uploadedAttachments;


    public function mount($test_case_id)
    {
        $this->tc_id = $test_case_id;
        $this->test_case = TestCase::with('comments')->where('id', $test_case_id)
            ->where('tc_project_id', auth()->user()->default_project)
            ->first();
        if ($this->test_case) {
            $this->tc_name = $this->test_case->tc_name;
            $this->tc_description = $this->test_case->tc_description;
            $this->tc_status = $this->test_case->tc_status;
            $this->tc_approval_request = $this->test_case->tc_approval_request;
            $this->tc_project_id = $this->test_case->tc_project_id;
            $this->tc_build_id = $this->test_case->tc_build_id;
            $this->tc_module_id = $this->test_case->tc_module_id;
            $this->tc_requirement_id = $this->test_case->tc_requirement_id;
            $this->tc_test_scenario_id = $this->test_case->tc_test_scenario_id;
            $this->tc_testing_type = $this->test_case->tc_testing_type;
            $this->tc_estimate_time = $this->test_case->tc_estimate_time;
            $this->tc_pre_conditions = $this->test_case->tc_pre_conditions;
            $this->tc_detailed_steps = $this->test_case->tc_detailed_steps;
            $this->tc_expected_result = $this->test_case->tc_expected_result;
            $this->tc_post_conditions = $this->test_case->tc_post_conditions;
            $this->tc_execution_type = $this->test_case->tc_execution_type;
            $this->tc_priority = $this->test_case->tc_priority;
            $this->tc_assigned_to = $this->test_case->tc_assigned_to;
            $this->tc_comment = '';
            $this->tempAttachments = [];
            $this->uploadedAttachments = [];
        } else {
            Toaster::error('Test case not found or you do not have permission to edit this test case.');
            return $this->redirect(route('test-cases'), true);
        }

        $this->loadFormBuilds();
        $this->loadFormModules();
        $this->loadFormRequirements();
        $this->loadFormTestScenarios();
        $this->form_selected_build_name = $this->test_case->build->name ?? null;
        $this->form_selected_module_name = $this->test_case->module->module_name ?? null;
        $this->form_selected_requirement_name = $this->test_case->requirement->requirement_title ?? null;
        $this->form_selected_test_scenario_name = $this->test_case->testScenario->ts_name ?? null;
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
        if ($this->tc_build_id === $build['id']) {
            return;
        }
        $this->tc_build_id = $build['id'];
        $this->form_selected_build_name = $build['name'];

        $this->resetModuleID();
    }

    public function resetBuildID()
    {
        $this->tc_build_id = null;
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
            ->where('build_id', $this->tc_build_id)
            ->where('project_id', auth()->user()->default_project)
            ->get(['id', 'module_name']);
    }

    public function updatedFormSearchModule()
    {
        $this->loadFormModules();
    }

    public function assignModuleID($module)
    {
        $this->tc_module_id = $module['id'];
        $this->form_selected_module_name = $module['module_name'];

        $this->resetRequirementID();
    }

    public function resetModuleID()
    {
        $this->tc_module_id = null;
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
            ->where('build_id', $this->tc_build_id)
            ->where('module_id', $this->tc_module_id)
            ->get(['id', 'requirement_title']);
        // dd($this->form_requirements);
    }

    public function updatedFormSearchRequirement()
    {
        $this->loadFormRequirements();
    }

    public function assignRequirementID($requirement)
    {
        $this->tc_requirement_id = $requirement['id'];
        $this->form_selected_requirement_name = $requirement['requirement_title'];

        $this->resetTestScenarioID();
    }
    public function resetRequirementID()
    {
        $this->tc_requirement_id = null;
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
            ->where('ts_build_id', $this->tc_build_id)
            ->where('ts_module_id', $this->tc_module_id)
            ->where('ts_requirement_id', $this->tc_requirement_id)
            ->get(['id', 'ts_name']);
    }

    public function updatedFormSearchTestScenario()
    {
        $this->loadFormTestScenarios();
    }

    public function assignTestScenarioID($test_scenario)
    {
        $this->tc_test_scenario_id = $test_scenario['id'];
        $this->form_selected_test_scenario_name = $test_scenario['ts_name'];
    }
    public function resetTestScenarioID()
    {
        $this->tc_test_scenario_id = null;
        $this->form_selected_test_scenario_name = null;
        $this->loadFormTestScenarios();
    }

    /*
        --- Form Methods ---
    */

    /* -- Attachments Handling -- */
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
        $this->validate([
            'tc_name' => 'required|string|min:3|max:255|unique:test_cases,tc_name,'.($this->test_case->id ?? 'NULL').',id',
            'tc_description' => 'required|string|min:3|max:1000',
            'tc_status' => 'required|string|in:pending,approved,rejected',
            'tc_approval_request' => 'nullable|exists:users,id',
            'tc_project_id' => 'required|exists:projects,id',
            'tc_build_id' => 'nullable|exists:builds,id',
            'tc_module_id' => 'nullable|exists:modules,id',
            'tc_requirement_id' => 'nullable|exists:requirements,id',
            'tc_test_scenario_id' => 'nullable|exists:test_scenarios,id',
            'tc_testing_type' => 'nullable|string',
            'tc_estimate_time' => 'nullable|numeric|min:0',
            'tc_pre_conditions' => 'nullable|string|max:2000',
            'tc_detailed_steps' => 'nullable|string|max:5000',
            'tc_expected_result' => 'nullable|string|max:2000',
            'tc_post_conditions' => 'nullable|string|max:2000',
            'tc_execution_type' => 'nullable|string|in:cypress,manual,automated',
            'tc_priority' => 'nullable|string|in:low,medium,high',
            'tc_assigned_to' => 'nullable|exists:users,id',
            'tc_comment' => 'nullable|string|max:1000',
            'uploadedAttachments.*' => 'file|max:61440|mimes:gif,jpg,jpeg,png,pdf,docx,csv,xls,ppt,mp4,webm,msg,eml',
        ]);

        $attachmentIds = $this->test_case->tc_attachments ?? [];
        if ($this->uploadedAttachments) {
            foreach ($this->uploadedAttachments as $attachment) {
                if (is_object($attachment)) {
                    $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                    $extension = $attachment->getClientOriginalExtension();
                    $timestamp = now()->timestamp;
                    $customName = "{$filename}_{$timestamp}.{$extension}";
                    $path = $attachment->storeAs('attachments/requirement', $customName);
                    $attachment = Attachment::create([
                        'filename' => $customName,
                        'file_type' => $attachment->getClientMimeType(),
                        'file_path' => $path,
                        'project_id' => $this->tc_project_id,
                    ]);
                    $attachmentIds[] = $attachment->id;
                }
            }
        }
        $this->test_case->update([
            'tc_name' => $this->tc_name,
            'tc_description' => $this->tc_description,
            'tc_status' => $this->tc_status,
            'tc_approval_request' => $this->tc_approval_request,
            'tc_project_id' => $this->tc_project_id,
            'tc_build_id' => $this->tc_build_id,
            'tc_module_id' => $this->tc_module_id,
            'tc_requirement_id' => $this->tc_requirement_id,
            'tc_test_scenario_id' => $this->tc_test_scenario_id,
            'tc_testing_type' => $this->tc_testing_type,
            'tc_estimate_time' => $this->tc_estimate_time,
            'tc_pre_conditions' => $this->tc_pre_conditions,
            'tc_detailed_steps' => $this->tc_detailed_steps,
            'tc_expected_result' => $this->tc_expected_result,
            'tc_post_conditions' => $this->tc_post_conditions,
            'tc_execution_type' => $this->tc_execution_type,
            'tc_priority' => $this->tc_priority,
            'tc_assigned_to' => $this->tc_assigned_to,
            'tc_attachments' => $attachmentIds,
        ]);
        TestCaseVersion::create([
            'test_case_id' => $this->test_case->id,
            'tc_name' => $this->tc_name,
            'tc_description' => $this->tc_description,
            'tc_status' => $this->tc_status,
            'tc_approval_request' => $this->tc_approval_request,
            'tc_project_id' => $this->tc_project_id,
            'tc_build_id' => $this->tc_build_id,
            'tc_module_id' => $this->tc_module_id,
            'tc_requirement_id' => $this->tc_requirement_id,
            'tc_test_scenario_id' => $this->tc_test_scenario_id,
            'tc_testing_type' => $this->tc_testing_type,
            'tc_estimate_time' => $this->tc_estimate_time,
            'tc_pre_conditions' => $this->tc_pre_conditions,
            'tc_detailed_steps' => $this->tc_detailed_steps,
            'tc_expected_result' => $this->tc_expected_result,
            'tc_post_conditions' => $this->tc_post_conditions,
            'tc_execution_type' => $this->tc_execution_type,
            'tc_priority' => $this->tc_priority,
            'tc_assigned_to' => $this->test_case->assigned_to,
            'tc_created_by' => auth()->user()->id,
            'tc_attachments' => $attachmentIds,
        ]);
        if ($this->tc_comment) {
            Comment::create([
                'comment' => $this->tc_comment,
                'test_case_id' => $this->test_case->id,
                'user_id' => auth()->user()->id
            ]);
        }
        Comment::create([
            'comment' => auth()->user()->username.' updated test case.',
            'test_case_id' => $this->test_case->id,
            'user_id' => auth()->user()->id
        ]);
        Toaster::success('Test case updated successfully');
        return $this->redirect(route('test-cases'), true);
    }

    public function render()
    {
        $test_case_versions = TestCaseVersion::with(['build', 'module', 'requirement', 'test_scenario', 'created_by'])
            ->where('test_case_id', $this->tc_id)
            ->where('tc_project_id', auth()->user()->default_project)
            // ->orderBy('created_at', 'desc')
            ->get()->map(function ($version) {
                $version->attachments = Attachment::whereIn('id', $version->tc_attachments)->pluck('filename');
                return $version;
            });

        $attachments = Attachment::whereIn('id', $this->test_case->tc_attachments)->where('project_id', $this->test_case->tc_project_id)->get();
        return view('livewire.test-case.edit-test-case', compact('test_case_versions', 'attachments'));
    }
}
