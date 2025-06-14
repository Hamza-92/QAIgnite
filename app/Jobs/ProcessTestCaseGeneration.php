<?php

namespace App\Jobs;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;
use App\Models\AiTestGeneration;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Masmerise\Toaster\Toaster;

class ProcessTestCaseGeneration implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public $generation;
    public $testCases;
    public function __construct(AiTestGeneration $generation)
    {
        $this->generation = $generation;
        $this->testCases = [];
    }

    public function handle()
    {
        $this->generation->update(['status' => 'processing']);

        try {
            $response = Http::connectTimeout(2000)
                ->retry(3, 1000)
                ->withHeaders([
                    'Authorization' => 'Bearer '.env('GITHUB_AI_KEY'),
                    'Content-Type' => 'application/json',
                    'HTTP-Referer' => config('app.url'),
                    'X-Title' => 'Test Case Generator',
                ])->post('https://models.github.ai/inference/chat/completions', [
                        'model' => 'openai/gpt-4.1',
                        'messages' => [
                            ['role' => 'system', 'content' => $this->getSystemPrompt()],
                            ['role' => 'user', 'content' => $this->generation->prompt],
                        ],
                        'temperature' => 0.7,
                        // 'max_tokens' => 1200,
                    ]);

            if ($response->successful()) {
                $content = $response->json()['choices'][0]['message']['content'];
                $this->parseTestCases($content);
                $this->generation->update([
                    'status' => 'completed',
                    'response' => $this->testCases,
                ]);
                Toaster::success('Test case generated successfully.');
            } else {
                $error = 'API Error: '.$response->status().' - '.($response->json()['error']['message'] ?? 'Unknown error');
                $this->generation->update([
                    'status' => 'failed',
                    'error_message' => $error,
                ]);
                Toaster::error('An error occured while generating test cases.');
            }
        } catch (\Throwable $e) {
            $this->generation->update([
                'status' => 'failed',
                'error_message' => $e->getMessage(),
            ]);
            Toaster::error('An error occured while generating test cases. \n Visit the page to see details.');
        }
    }

    protected function getSystemPrompt()
    {
        return <<<PROMPT
You are a senior QA engineer. Generate comprehensive test cases based on the provided requirements following these guidelines:

1. Test Case Format:
   - Test Case ID: TC_[descriptive_name_underscores]
     Example: For login test, use TC_login_successful
   - Summary: Clear one-sentence description of what's being tested
   - Steps: Numbered steps only (no expected results)
   - Expected Results: Clear verification points for the test

2. Structure each test case with these exact headings:
   Test Case ID: [ID]
   Summary: [summary]
   Steps:
   1. [step].
   2. [step].
   Expected Results:
   - [result].
   - [result].

3. Test Case Requirements:
   - Include positive, negative, and edge cases
   - Cover all functional aspects
   - Make each test case independent
   - Keep steps concise but unambiguous
   - Expected results should be verifiable

4. Output Instructions:
   - Separate test cases with two newlines
   - Do not include additional explanations
   - Generate as many test cases as needed to cover the requirement
PROMPT;
    }

    protected function parseTestCases($content)
    {
        $this->testCases = [];

        // Split content by double newlines to separate test cases
        $rawTestCases = preg_split('/\n\s*\n/', trim($content));

        foreach ($rawTestCases as $rawTestCase) {
            if (empty(trim($rawTestCase)))
                continue;

            $testCase = [
                'id' => '',
                'summary' => '',
                'steps' => '',
                'expected' => ''
            ];

            // Extract Test Case ID
            if (preg_match('/Test Case ID:\s*(.*)/i', $rawTestCase, $matches)) {
                $id = trim($matches[1]);

                // Clean up the ID
                $id = str_replace('TC_', '', $id); // Remove any existing TC_
                $id = Str::snake($id); // Convert to snake_case
                $id = preg_replace('/_+/', '_', $id); // Remove duplicate underscores
                $id = trim($id, '_'); // Trim leading/trailing underscores
                $id = strtolower($id); // Ensure lowercase

                // Remove common problematic patterns
                $id = str_replace(['t_c_', 'test_case_'], '', $id);

                $testCase['id'] = 'TC_'.$id;
            }

            // Extract Summary
            if (preg_match('/Summary:\s*(.*)/i', $rawTestCase, $matches)) {
                $testCase['summary'] = trim($matches[1]);
            }

            // Extract Steps
            if (preg_match('/Steps:\s*([\s\S]*?)(?=Expected Results:)/i', $rawTestCase, $matches)) {
                $steps = trim($matches[1]);
                // Clean up step formatting
                // $steps = preg_replace('/^\s*\d+\.\s*/m', '', $steps); // Remove numbers
                $steps = preg_split('/\r\n|\r|\n/', $steps); // Split into array
                $steps = array_filter(array_map('trim', $steps)); // Clean each line
                $testCase['steps'] = implode("\n", $steps);
            }

            // Extract Expected Results
            if (preg_match('/Expected Results:\s*([\s\S]*)/i', $rawTestCase, $matches)) {
                $expected = trim($matches[1]);
                // Clean up expected results formatting
                $expected = preg_replace('/^-\s*/m', '', $expected); // Remove bullets
                $expected = preg_split('/\r\n|\r|\n/', $expected); // Split into array
                $expected = array_filter(array_map('trim', $expected)); // Clean each line
                $testCase['expected'] = implode("\n", $expected);
            }

            if (! empty($testCase['id'])) {
                $this->testCases[] = $testCase;
            }
        }
        // dd($this->testCases);
    }
}
