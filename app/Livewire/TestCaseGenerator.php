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

        try {
            // Prepare the prompt
            $prompt = "Generate a test case for the following scenario: " . $this->scenario;
            $prompt = preg_replace('/\s+/', ' ', trim($prompt)); // Normalize whitespace in one step

            $apiKey = env('OPENROUTER_API_KEY');
            if (empty($apiKey)) {
                throw new \Exception('API key is missing');
            }

            $data = [
                "model" => "deepseek/deepseek-r1:free",
                "messages" => [
                    ["role" => "user", "content" => $prompt]
                ]
            ];

            $ch = curl_init("https://openrouter.ai/api/v1/chat/completions");
            curl_setopt_array($ch, [
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_HTTPHEADER => [
                    "Content-Type: application/json",
                    "Authorization: Bearer $apiKey"
                ],
                CURLOPT_POST => true,
                CURLOPT_POSTFIELDS => json_encode($data),
                // CURLOPT_TIMEOUT => 30, // Added timeout
            ]);

            $response = curl_exec($ch);

            if (curl_errno($ch)) {
                throw new \Exception('Curl error: ' . curl_error($ch));
            }

            $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
            if ($httpCode !== 200) {
                throw new \Exception("API request failed with HTTP code: $httpCode");
            }

            curl_close($ch);

            $result = json_decode($response, true);
            if (json_last_error() !== JSON_ERROR_NONE) {
                throw new \Exception('Invalid JSON response');
            }

            $this->result = $result['choices'][0]['message']['content'] ?? 'No response';
        } catch (\Exception $e) {
            $this->result = 'Error: ' . $e->getMessage();
        } finally {
            $this->loading = false;
        }
    }

    public function render()
    {
        return view('livewire.test-case-generator');
    }
}
