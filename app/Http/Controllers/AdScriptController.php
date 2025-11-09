<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Enums\AdScriptTaskStatus;
use App\Jobs\SendTaskToN8NJob;
use App\Models\AdScriptTask;
use App\Repositories\AdScriptTaskRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class AdScriptController extends Controller
{
    private array $commonValidations = ['required', 'string'];

    public function __construct(
        private readonly AdScriptTaskRepository $taskRepository
    ) {
    }

    public function store(Request $request): JsonResponse
    {
        $validated = $request->validate([
            'reference_script' => $this->commonValidations,
            'outcome_description' => $this->commonValidations,
        ]);

        $task = $this->taskRepository->create($validated);

        SendTaskToN8NJob::dispatch($task)->delay(now()->addSecond());

        return response()->json([
            'task_id' => $task->id,
            'status' => AdScriptTaskStatus::PENDING->value,
        ], 201);
    }

    public function result(Request $request, AdScriptTask $task): JsonResponse
    {
        $validated = $request->validate([
            'new_script' => $this->commonValidations,
            'analysis' => $this->commonValidations,
        ]);

        try {
            $this->taskRepository->markAsCompleted(
                $task,
                array_merge($validated, ['status' => AdScriptTaskStatus::COMPLETED->value])
            );

            return response()->json(['success' => true]);
        } catch (\Throwable) {
            return response()->json(['success' => false], 500);
        }
    }
}
