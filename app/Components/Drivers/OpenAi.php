<?php

namespace App\Components\Drivers;

use GuzzleHttp\Client;
use Illuminate\Support\Str;
use GuzzleHttp\Exception\ClientException;
use GuzzleHttp\Exception\GuzzleException;

class OpenAi
{
    protected $apikey;
    protected $model;
    protected $endpoint = "https://api.openai.com/v1/completions";
    protected $endpoint_gpt = "https://api.openai.com/v1/chat/completions";

    public function __construct()
    {
        $this->model = config('artisan.openai_model', 'gpt-3.5-turbo');
        $this->apikey = config('artisan.openai_api_key');
    }

    public function parse($prompt)
    {
        try {
            $isChatGtp = Str::contains($this->model, 'gpt');
            $prompt =  $isChatGtp ? 'Forget all previous instructions. ' . $prompt : $prompt;
            $endpoint = $isChatGtp ? $this->endpoint_gpt : $this->endpoint;
            $data = $isChatGtp ? [
                'model' => $this->model,
                "messages" => [["role" => "user", "content" => $prompt]],
                "temperature" => 0,
                'max_tokens' => min(
                    $this->calculate_max_tokens($prompt),
                    $this->get_max_tokens_for_model($this->model)
                ),
            ] : [
                'model' => $this->model,
                'prompt' => $prompt,
                "temperature" => 0,
                'max_tokens' => min(
                    $this->calculate_max_tokens($prompt),
                    $this->get_max_tokens_for_model($this->model)
                ),
            ];
            $client = new Client();
            $response = $client->request('POST', $endpoint, [
                'body' => json_encode($data),
                'headers' => [
                    'Authorization' => 'Bearer ' . $this->apikey,
                    'Content-Type' => 'application/json',
                ],
            ]);

            $body = $response->getBody();
            $json = json_decode($body, true);
        } catch (ClientException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        } catch (GuzzleException $e) {
            return ['success' => false, 'message' => $e->getMessage()];
        }

        $choices = $json['choices'];
        if (count($choices) == 0) {
            return ['success' => false, 'message' => __('common.somethingWentWrong')];
        }

        $resultText = trim($choices[0]['message']['content']);
        $resultUsage = $json['usage'];

        return ['success' => true, 'text' => $resultText, 'usage' => $resultUsage];
    }

    protected function calculate_max_tokens($inputText)
    {
        // 4 characters are equal to 1 toeken.
        return 4000 - intval(get_number_of_words_in_text($inputText) * 1.3);
    }

    protected function get_max_tokens_for_model($model)
    {
        if ($model == 'text-davinci-002' || $model == 'text-davinci-003' || $model == 'gpt-3.5-turbo') {
            return 3700;
        }

        return 1700;
    }
}
