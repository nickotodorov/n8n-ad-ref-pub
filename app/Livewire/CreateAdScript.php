<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Http\Controllers\AdScriptController;
use Illuminate\Http\Request;
use Livewire\Component;
use Illuminate\Contracts\View\View;

class CreateAdScript extends Component
{
    public string $reference_script = '';
    public string $outcome_description = '';
    public ?string $message = null;

    protected array $rules = [
        'reference_script' => [
            'required',
            'string',
        ],
        'outcome_description' => [
            'required',
            'string',
            'max:2000',
        ]
    ];

    public function submit(): void
    {
        $this->validate();

        $request = Request::create('/api/ad-scripts', 'POST', [
            'reference_script' => $this->reference_script,
            'outcome_description' => $this->outcome_description,
        ]);

        $controller = app(AdScriptController::class);
        $response = $controller->store($request);
        $data = $response->getData(true);

        if (isset($data['task_id'])) {
            $this->message = 'Task created! Refresh below to see status.';
            $this->reset(['reference_script', 'outcome_description']);
            $this->dispatch('taskCreated');
            return;
        }

        $this->message = 'Failed: ' . json_encode($data);
    }

    public function render(): View
    {
        return view('livewire.create-ad-script');
    }
}
