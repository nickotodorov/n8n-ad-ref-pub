<?php

declare(strict_types=1);

namespace App\Repositories;

use App\Enums\AdScriptTaskStatus;
use App\Models\AdScriptTask;

class AdScriptTaskRepository
{
    public function create(array $data): AdScriptTask
    {
        return AdScriptTask::create($data);
    }

    public function markAsFailed(AdScriptTask $task, string $msg): AdScriptTask
    {
        $task->update([
            'status' => AdScriptTaskStatus::FAILED,
            'error' => $msg,
        ]);

        return $task;
    }

    public function markAsCompleted(AdScriptTask $task, array $data): AdScriptTask
    {
        $task->update($data);

        return $task;
    }
}
