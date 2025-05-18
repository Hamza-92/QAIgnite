<?php

namespace App\Livewire\AiTestCaseGenerator;

use App\Jobs\ProcessTestCaseGeneration;
use App\Models\AiTestGeneration;
use App\Models\Comment;
use App\Models\TestCase;
use Exception;
use Livewire\Component;
use Masmerise\Toaster\Toaster;

class TestCaseGenerator extends Component
{
    public $prompt = '';
    public $generatedTestCases;

    public $latestGeneration;
    public $selectedTestCases;

    protected $rules = [
        'prompt' => 'required|string|min:10',
    ];

    public function mount()
    {
        // $this->generatedTestCases = AiTestGeneration::where('user_id', auth()->id())
        //     ->orderBy('created_at', 'desc')
        //     ->get();
        $this->latestGeneration = AiTestGeneration::where('user_id', auth()->id())
            ->latest()
            ->first();
        $this->selectedTestCases = [];
        // dd($this->latestGeneration->response);
    }

    public function generate()
    {
        $this->validate();

        $gen = AiTestGeneration::create([
            'user_id' => auth()->id(),
            'prompt' => $this->prompt,
            'status' => 'pending',
        ]);

        ProcessTestCaseGeneration::dispatch($gen);

        $this->latestGeneration = $gen;
        $this->reset('prompt');
    }

    public function regenerate()
    {
        $this->prompt = $this->latestGeneration->prompt;
        $this->generate();

    }

    public function importTestCase($testCase)
    {
        try {
            if (! TestCase::where('tc_name', $testCase['id'])->exists()) {
                $test_case = TestCase::create([
                    'tc_name' => $testCase['id'],
                    'tc_description' => $testCase['summary'],
                    'tc_status' => 'approved',
                    'tc_project_id' => auth()->user()->default_project,
                    'tc_detailed_steps' => $testCase['steps'],
                    'tc_expected_results' => $testCase['expected'],
                    'tc_created_by' => auth()->id()
                ]);
                Comment::create([
                    'comment' => auth()->user()->username.' created test case.',
                    'test_case_id' => $test_case->id,
                    'user_id' => auth()->user()->id
                ]);
                Toaster::success('Test case successfully added.');
            } else {
                Toaster::error('Test case already present.');
            }
        } catch (Exception $e) {
            Toaster::error($e);
        }
    }

    public function importSelectedTestCases()
{
    if (!is_array($this->selectedTestCases)) {
        $this->selectedTestCases = [];
    }

    $this->selectedTestCases = array_filter($this->selectedTestCases, function($item) {
        return !empty($item);
    });

    if (empty($this->selectedTestCases)) {
        Toaster::error('Please select the test cases to import.');
        return;
    }

    $importedCount = 0;

    try {
        foreach ($this->selectedTestCases as $testCaseJson) {
            $testCase = json_decode($testCaseJson, true);

            if (!is_array($testCase)) {
                continue;
            }

            if (!TestCase::where('tc_name', $testCase['id'])
                ->where('tc_project_id', auth()->user()->default_project)
                ->exists()) {

                    $test_case = TestCase::create([
                    'tc_name' => $testCase['id'],
                    'tc_description' => $testCase['summary'],
                    'tc_status' => 'approved',
                    'tc_project_id' => auth()->user()->default_project,
                    'tc_detailed_steps' => $testCase['steps'],
                    'tc_expected_results' => $testCase['expected'],
                    'tc_created_by' => auth()->id()
                ]);
                Comment::create([
                    'comment' => auth()->user()->username.' created test case.',
                    'test_case_id' => $test_case->id,
                    'user_id' => auth()->user()->id
                ]);
                $importedCount++;
            }
        }

        if ($importedCount > 0) {
            Toaster::success($importedCount.' test cases added successfully.');
        } else {
            Toaster::info('No new test cases were added.');
        }

        $this->selectedTestCases = [];

    } catch (Exception $e) {
        Toaster::error('An error occurred while importing test cases');
    }
}

    public function importAllTestCases()
    {
        $importedCount = 0;
        try {
            foreach ($this->latestGeneration->response as $testCase) {
                if (! TestCase::where('tc_name', $testCase['id'])->exists()) {
                    $test_case = TestCase::create([
                        'tc_name' => $testCase['id'],
                        'tc_description' => $testCase['summary'],
                        'tc_status' => 'approved',
                        'tc_project_id' => auth()->user()->default_project,
                        'tc_detailed_steps' => $testCase['steps'],
                        'tc_expected_results' => $testCase['expected'],
                        'tc_created_by' => auth()->id()
                    ]);
                    Comment::create([
                        'comment' => auth()->user()->username.' created test case.',
                        'test_case_id' => $test_case->id,
                        'user_id' => auth()->user()->id
                    ]);
                    $importedCount++;
                }
            }
            if ($importedCount > 0) {
                Toaster::success($importedCount.' test cases added successfully.');
            } else {
                Toaster::info('All test cases has already been imported.');
            }
        } catch (Exception $e) {
            Toaster::error('An error occurred while importing test cases.');
        }
    }
    public function render()
    {
        if ($this->latestGeneration) {
            $this->latestGeneration->refresh();
        }
        return view('livewire.ai-test-case-generator.test-case-generator');
    }
}
