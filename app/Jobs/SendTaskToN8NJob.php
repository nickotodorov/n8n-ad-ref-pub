<?php

declare(strict_types=1);

namespace App\Jobs;

use App\Models\AdScriptTask;
use App\Repositories\AdScriptTaskRepository;
use App\Services\N8nClient;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Bus\Dispatchable;

class SendTaskToN8NJob implements ShouldQueue
{
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;
    use Dispatchable;

    public function __construct(public readonly AdScriptTask $task) {}

    public function handle(): void
    {
        try {
            (new N8nClient())->runWorkflow([
                'task_id' => $this->task->id,
                'reference_script' => $this->task->reference_script,
                'outcome_description' => $this->task->outcome_description,
                'callback_url' => route('api.ad-scripts.result', $this->task->id),
            ]);
        } catch (\Throwable $e) {
            (new AdScriptTaskRepository())
                ->markAsFailed($this->task, $e->getMessage());
        }
    }
}
