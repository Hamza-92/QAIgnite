<?php

namespace App\Livewire\Requirement;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Requirement;
use App\Models\RequirementVersion;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class RequirementDetails extends Component
{
    public $requirement_id;

    public $comment;

    public function mount($requirement_id) {
        $this->requirement_id = $requirement_id;

        $this->comment = '';
    }

    public function saveComment() {
        $this->validate([
            'comment' => 'required|min:3|max:500'
        ]);

        Comment::create([
            'comment' => $this->comment,
            'user_id' => auth()->user()->id,
            'requirement_id' => $this->requirement_id
        ]);

        Toaster::success('Comment added');
        $this->comment = '';
    }

    public function render()
    {
        $requirement = Requirement::with(['build', 'module', 'testScenarios', 'testCases', 'assignedTo', 'createdBy', 'comments' => function($query) {
            $query->orderBy('created_at', 'desc');
            }, 'comments.user'])
            ->where('id', $this->requirement_id)
            ->where('project_id', auth()->user()->default_project)
            ->first();

        $requirement_versions = RequirementVersion::with(['build', 'module', 'testScenarios', 'testCases', 'assignedTo'])
            ->where('requirement_id', $this->requirement_id)
            ->where('project_id', auth()->user()->default_project)
            ->get()
            ->map(function ($version) {
            $version->attachments = Attachment::whereIn('id', $version->attachments)->pluck('filename');
            return $version;
            });

        $attachments = Attachment::whereIn('id', $requirement->attachments)->get();
            // dd($requirement_versions);
        return view('livewire.requirement.requirement-details', compact(['requirement', 'requirement_versions', 'attachments']));
    }
}
