<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Http;
use Livewire\Component;

class TestCaseGenerator extends Component
{
    public $scenario = '';
    public $result = '';
    public $loading = false;

    public function generateTestCases()
    {
        $this->loading = true;
        $this->result = '';

        $prompt = "Generate 3 detailed manual test cases based on this scenario:\n\n{$this->scenario}\n\nEach test case should have:\n- Title\n- Steps\n- Expected Result";

        $response = Http::withToken(env('GITHUB_AI_KEY'))->post('https://models.github.ai/inference', [
            'prompt' => $prompt,
            'max_tokens' => 1024,
            'temperature' => 0.7,
        ]);

        if ($response->successful()) {
            $this->result = $response->json('output') ?? 'No output received.';
        } else {
            $this->result = "Error: " . $response->body();
        }

        $this->loading = false;
    }

    public function render()
    {
        return view('livewire.test-case-generator');
    }
}
