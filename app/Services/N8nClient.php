<?php

declare(strict_types=1);

namespace App\Services;

use Illuminate\Support\Facades\Http;

class N8nClient
{
    protected string $baseUrl;
    protected ?string $apiKey;
    protected int $timeout;

    public function __construct()
    {
        $this->baseUrl = rtrim(config('n8n.api.base_url'), '/');
        $this->apiKey = config('n8n.api.key');
        $this->timeout = (int) config('n8n.timeout');
    }

    /**
     * @param array $payload
     * @return array
     */
    public function runWorkflow(array $payload = []): array
    {
        $headers = $this->apiKey ? ['Authorization' => "Bearer {$this->apiKey}"] : [];

        $response = Http::timeout($this->timeout)
            ->withHeaders($headers)
            ->post("{$this->baseUrl}/webhook/ad-refactor", $payload);

        if ($response->failed()) {
            throw new \RuntimeException(
                "N8N request failed: {$response->status()} {$response->body()}"
            );
        }

        $json = $response->json();

        return is_array($json) ? $json : [];
    }
}
