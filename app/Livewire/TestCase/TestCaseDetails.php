<?php

namespace App\Livewire\TestCase;

use App\Models\Attachment;
use App\Models\Comment;
use App\Models\TestCase;
use App\Models\TestCaseVersion;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class TestCaseDetails extends Component
{
    public $test_case_id;
    public $comment;
    public function mount($test_case_id) {
        $this->test_case_id = $test_case_id;

        $this->comment = '';
    }
    public function edit() {
        $this->dispatch('editTestCase', $this->test_case_id);
        return redirect()->route('test-cases', ['id' => $this->test_case_id]);
    }

    public function saveComment() {
        $this->validate([
            'comment' => 'required|min:3|max:500'
        ]);

        Comment::create([
            'comment' => $this->comment,
            'user_id' => auth()->user()->id,
            'test_case_id' => $this->test_case_id
        ]);

        Toaster::success('Comment added');
        $this->comment = '';
    }

    public function render()
    {
        $test_case = TestCase::with(['build', 'module', 'requirement', 'test_scenario', 'created_by', 'comments' => function($query) {
            $query->orderBy('created_at', 'asc');
            }, 'comments.user'])
            ->where('id', $this->test_case_id)
            ->where('tc_project_id', auth()->user()->default_project)
            ->first();

        if (!$test_case) {
            Toaster::error('Test case not found');
            return redirect()->route('test-cases');
        }
        if ($test_case->tc_project_id != auth()->user()->default_project) {
            Toaster::error('Test case not found');
            return redirect()->route('test-cases');
        }
        // Check if the user has access to the test case
        // if (!auth()->user()->hasAccessToTestCase($test_case)) {
        //     Toaster::error('You do not have access to this test case');
        //     return redirect()->route('test-cases');
        // }
        $test_case_versions = TestCaseVersion::with(['build', 'module', 'requirement', 'test_scenario', 'created_by'])
            ->where('test_case_id', $this->test_case_id)
            ->where('tc_project_id', auth()->user()->default_project)
            // ->orderBy('created_at', 'desc')
            ->get()->map(function ($version) {
                $version->attachments = Attachment::whereIn('id', $version->tc_attachments)->pluck('filename');
                return $version;
                });

            $attachments = Attachment::whereIn('id', $test_case->tc_attachments)->get();
        // dd($test_case);
        return view('livewire.test-case.test-case-details', compact(['test_case', 'test_case_versions', 'attachments']));
    }
}
