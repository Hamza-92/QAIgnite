<?php

namespace App\Livewire\Defect;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\Defect;
use App\Models\DefectVersion;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class DefectDetail extends Component
{
    public $defect;
    public $defect_versions;
    public $defect_id;
    public $comment;

    public function mount($defect_id)
    {

        $this->defect_id = $defect_id;
        $this->comment = '';

        $this->defect = Defect::with(['build', 'module', 'requirement', 'testScenario', 'testCase', 'createdBy', 'assignedTo', 'comments' => function ($query) {
            $query->orderBy('created_at', 'asc');
        }, 'comments.user'])
            ->where('id', $this->defect_id)
            ->where('def_project_id', auth()->user()->default_project)
            ->first();
        if (! $this->defect) {
            Toaster::error('Defect not found');
            return redirect()->route('defects');
        }
        if ($this->defect->def_project_id != auth()->user()->default_project) {
            Toaster::error('Defect not found');
            return redirect()->route('defects');
        }

        $this->defect_versions = DefectVersion::with(['build', 'module', 'requirement', 'testScenario', 'testCase', 'createdBy', 'assignedTo'])
            ->where('defect_id', $this->defect_id)
            ->where('def_project_id', auth()->user()->default_project)
            ->orderBy('created_at', 'desc')
            ->get()->map(function ($version) {
            $version->attachments = Attachment::whereIn('id', $version->def_attachments)->pluck('filename');
            return $version;
            });
    }
    public function edit()
    {
        $this->dispatch('editDefect', $this->defect_id);
        return redirect()->route('defects', ['id' => $this->defect_id]);
    }
    public function saveComment()
    {
        $this->validate([
            'comment' => 'required|min:3|max:500'
        ]);

        Comment::create([
            'comment' => $this->comment,
            'user_id' => auth()->user()->id,
            'defect_id' => $this->defect_id
        ]);

        Toaster::success('Comment added');
        $this->comment = '';
    }
    public function deleteAttachment($attachment_id)
    {
        $attachment = Attachment::find($attachment_id);
        if ($attachment) {
            $attachment->delete();
            Toaster::success('Attachment deleted');
        } else {
            Toaster::error('Attachment not found');
        }
    }
    public function render()
    {

        $attachments = Attachment::whereIn('id', $this->defect->def_attachments)->get();
        return view('livewire.defect.defect-detail', compact(['attachments']));
    }
}
