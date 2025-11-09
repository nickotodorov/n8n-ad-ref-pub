<?php

declare(strict_types=1);

namespace Tests\Feature;

use App\Enums\AdScriptTaskStatus;
use App\Jobs\SendTaskToN8NJob;
use App\Models\AdScriptTask;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Queue;
use Illuminate\Support\Facades\Http;
use Tests\TestCase;

class AdScriptFlowTest extends TestCase
{
    use RefreshDatabase;

    const URI = '/api/ad-scripts';

    public function test_happy_path_synchronous_response(): void
    {
        Http::fake([
            '*/webhook/ad-refactor' => Http::response([
                'task_id' => 1,
                'new_script' => 'New script from n8n',
                'analysis' => 'AI analysis',
            ], 200),
        ]);

        Queue::fake();

        $payload = [
            'reference_script' => 'Old script',
            'outcome_description' => 'Some description',
        ];

        $response = $this->postJson(self::URI, $payload);

        $response->assertStatus(200)
            ->assertJsonStructure(['task_id', 'status']);


        Queue::assertPushed(SendTaskToN8NJob::class);
    }

    public function test_error_path_n8n_returns_500(): void
    {
        Http::fake([
            '*' => Http::response('Internal error', 500)
        ]);

        $this->postJson(self::URI, [
            'reference_script' => 'Old script',
            'outcome_description' => 'Some description'
        ])
            ->assertStatus(200);

        $this->artisan('queue:work --once');

        $this->assertDatabaseHas('ad_script_tasks', [
            'status' => AdScriptTaskStatus::FAILED->value,
        ]);
    }
}
