<?php

namespace App\Livewire\Requirement;

use App\Models\Attachment;
use App\Models\Build;
use App\Models\Comment;
use App\Models\Module;
use App\Models\Requirement;
use App\Models\RequirementVersion;
use Livewire\Attributes\On;
use Livewire\Attributes\Rule;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Masmerise\Toaster\Toaster;

class Requirements extends Component
{
    use WithFileUploads, WithPagination;

    // Requirement Attributes
    public $requirement;
    public $created_by;
    public $project_id;
    public $build_id;
    public $module_id;
    // public $parent_requirement_id;
    public $requirement_title;
    public $requirement_summary;
    public $requirement_source;
    public $requirement_type;
    public $status;
    #[Rule(['attachments.*' => 'file|max:10240|mimes:gif,jpg,jpeg,png,pdf,docx,csv,xls,ppt,mp4,webm,msg,eml'])]
    public array $tempAttachments;
    public array $attachments;
    public $comment;
    public $requirement_version_history;
    public $assigned_to;

    // Attribute Rules
    protected $rules = [
        'requirement_title' => 'required|string|min:3|max:255',
        'requirement_summary' => 'required|string|min:3|max:500',
        'requirement_type' => 'nullable|sometimes|string|in:Functional,UX/UI',
        'requirement_source' => 'nullable|sometimes|string|min:3|max:255',
        'status' => 'nullable|sometimes|string|in:Backlog,Testing,Completed,Ready for Testing,Design,To Do,In progress,Done',
        'attachments' => 'nullable|sometimes|array',
        'comment' => 'nullable|sometimes|string|min:3|max:500',
        'created_by' => 'integer',
        'project_id' => 'integer',
        'build_id' => 'nullable|sometimes|integer',
        'module_id' => 'nullable|sometimes|integer',
        // 'parent_requirement_id' => 'nullable|sometimes|integer',
        'assigned_to' => 'nullable|sometimes|integer',
    ];

    public function mount()
    {
        $this->initializeValues();
    }

    public function initializeValues()
    {
        $this->requirement = null;
        $this->requirement_title = '';
        $this->requirement_summary = '';
        $this->requirement_type = '';
        $this->requirement_source = '';
        $this->status = '';
        $this->tempAttachments = [];
        $this->attachments = [];
        $this->created_by = auth()->user()->id;
        $this->project_id = auth()->user()->default_project;
        $this->build_id = null;
        $this->module_id = null;
        $this->comment = null;
        $this->requirement_version_history = null;

        $this->loadFormBuilds();
        $this->loadFormModules();
    }


    /*
    ===============
    Form handling
    ===============
    */

    /* -- Form Controller -- */
    public $create;
    public $edit;

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
        $this->module_id = null;
        $this->form_selected_module_name = null;

        // Refresh list of modules
        $this->loadFormModules();
    }

    public function resetBuildID()
    {
        $this->build_id = null;
        $this->form_selected_build_name = null;
        $this->module_id = null;
        $this->form_selected_module_name = null;
        $this->loadFormModules();
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
    }

    public function resetModuleID()
    {
        $this->module_id = null;
        $this->form_selected_module_name = null;
    }

    /* -- Attachments Handling -- */
    public function updatedTempAttachments()
    {
        foreach ($this->tempAttachments as $tempAttachment) {
            $this->attachments[] = $tempAttachment;
        }
        $this->temp_attachments = [];
    }
    public function removeAttachment($index)
    {
        if (isset($this->attachments[$index])) {
            $this->attachments[$index]->delete();
            unset($this->attachments[$index]);
            $this->attachments = array_values($this->attachments);
        }
    }

    /*
        -- Form Methods --
    */

    /* -- Reset Form -- */
    public function resetForm()
    {
        $this->create = false;
        $this->edit = false;
        $this->initializeValues();
    }

    /* -- Initialize edit form --*/
    #[On('editRequirement')]
    public function loadRequirement($id)
    {
        $this->resetForm();
        $this->edit = true;

        $this->requirement = Requirement::findOrFail($id);

        $this->requirement_title = $this->requirement->requirement_title;
        $this->requirement_summary = $this->requirement->requirement_summary;
        $this->requirement_type = $this->requirement->requirement_type;
        $this->requirement_source = $this->requirement->requirement_source;
        $this->status = $this->requirement->status;
        $this->created_by = $this->requirement->created_by;
        $this->project_id = $this->requirement->project_id;
        $this->build_id = $this->requirement->build_id;
        $this->module_id = $this->requirement->module_id;
        $this->assigned_to = $this->requirement->assigned_to;

        // $this->attachments = Attachment::whereIn('id', $this->requirement->attachments)->get()->toArray();
        // $this->requirement_version_history = $this->requirement->requirementVersions;

        if ($this->build_id) {
            $build = Build::find($this->build_id);
            $this->form_selected_build_name = $build ? $build->name : null;
        }

        if ($this->module_id) {
            $module = Module::find($this->module_id);
            $this->form_selected_module_name = $module ? $module->module_name : null;
        }
    }

    public function save()
    {
        $this->validate();

        $existing_requirement = Requirement::where('requirement_title', $this->requirement_title)
            ->where('project_id', auth()->user()->default_project)
            ->where('id', '!=', $this->requirement->id ?? null)
            ->first();

        if ($this->edit) {
            if ($existing_requirement) {
                $this->addError('requirement_title', 'Requirement with this title already exists.');
                return;
            } else {
                $attachmentIds = $this->requirement->attachments ?? [];
                if ($this->attachments) {
                    foreach ($this->attachments as $attachment) {
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
                                'project_id' => $this->project_id,
                            ]);
                            $attachmentIds[] = $attachment->id;
                        }
                    }
                }

                $this->requirement->update([
                    'requirement_title' => $this->requirement_title,
                    'requirement_summary' => $this->requirement_summary,
                    'requirement_type' => $this->requirement_type,
                    'requirement_source' => $this->requirement_source,
                    'status' => $this->status,
                    'build_id' => $this->build_id,
                    'module_id' => $this->module_id,
                    'assigned_to' => $this->assigned_to,
                    'attachments' => $attachmentIds,
                ]);

                RequirementVersion::create([
                    'requirement_id' => $this->requirement->id,
                    'requirement_title' => $this->requirement_title,
                    'requirement_summary' => $this->requirement_summary,
                    'requirement_type' => $this->requirement_type,
                    'requirement_source' => $this->requirement_source,
                    'status' => $this->status,
                    'created_by' => $this->created_by,
                    'project_id' => $this->project_id,
                    'build_id' => $this->build_id,
                    'module_id' => $this->module_id,
                    'assigned_to' => $this->assigned_to,
                    'attachments' => $attachmentIds,
                ]);

                if ($this->comment) {
                    Comment::create([
                        'comment' => $this->comment,
                        'requirement_id' => $this->requirement->id,
                        'user_id' => auth()->user()->id,
                    ]);
                }

                Toaster::success('Requirement updated');
            }
        }

        $this->resetForm();
        $this->dispatch('requirement_saved');


        if ($this->create) {
            $this->validate();
            $existing_requirement = Requirement::where('requirement_title', $this->requirement_title)
                ->where('project_id', auth()->user()->default_project)
                ->first();
            if ($existing_requirement) {
                $this->addError('requirement_title', 'Requirement already exists.');
                return;
            } else {
                $attachmentIds = [];
                if ($this->attachments) {
                    foreach ($this->attachments as $attachment) {
                        $filename = pathinfo($attachment->getClientOriginalName(), PATHINFO_FILENAME);
                        $extension = $attachment->getClientOriginalExtension();
                        $timestamp = now()->timestamp;
                        $customName = "{$filename}_{$timestamp}.{$extension}";
                        $path = $attachment->storeAs('attachments/requirement', $customName);
                        $attachment = Attachment::create([
                            'filename' => $customName,
                            'file_type' => $attachment->getClientMimeType(),
                            'file_path' => $path,
                            'project_id' => $this->project_id,
                        ]);
                        $attachmentIds[] = $attachment->id;
                    }
                }
                $this->requirement = Requirement::create([
                    'requirement_title' => $this->requirement_title,
                    'requirement_summary' => $this->requirement_summary,
                    'requirement_type' => $this->requirement_type,
                    'requirement_source' => $this->requirement_source,
                    'status' => $this->status,
                    'created_by' => $this->created_by,
                    'project_id' => $this->project_id,
                    'build_id' => $this->build_id,
                    'module_id' => $this->module_id,
                    // 'parent_requirement_id' => $this->parent_requirement_id,
                    'assigned_to' => $this->assigned_to,
                    'attachments' => $attachmentIds,
                ]);
                RequirementVersion::create([
                    'requirement_id' => $this->requirement->id,
                    'requirement_title' => $this->requirement_title,
                    'requirement_summary' => $this->requirement_summary,
                    'requirement_type' => $this->requirement_type,
                    'requirement_source' => $this->requirement_source,
                    'status' => $this->status,
                    'created_by' => $this->created_by,
                    'project_id' => $this->project_id,
                    'build_id' => $this->build_id,
                    'module_id' => $this->module_id,
                    // 'parent_requirement_id' => $this->parent_requirement_id,
                    'assigned_to' => $this->assigned_to,
                    'attachments' => $attachmentIds,
                ]);
                Comment::create([
                    'comment' => auth()->user()->username.' created requirement',
                    'requirement_id' => $this->requirement->id,
                    'user_id' => auth()->user()->id
                ]);
                if ($this->comment) {
                    Comment::create([
                        'comment' => $this->comment,
                        'requirement_id' => $this->requirement->id,
                        'user_id' => auth()->user()->id
                    ]);
                }
                Toaster::success('Requirement added');
            }
        }

        $this->resetForm();
        $this->dispatch('requirement_saved');
    }

    public function render()
    {
        return view('livewire.requirement.requirements');
    }
}
