<?php

declare(strict_types=1);

namespace App\Livewire;

use App\Models\AdScriptTask;
use Illuminate\View\View;
use Livewire\Component;
use Illuminate\Database\Eloquent\Collection;

class AdScriptList extends Component
{
    public Collection  $tasks;

    public function mount(): void
    {
        $this->tasks = AdScriptTask::orderBy('created_at', 'desc')->get();
    }


    public function render(): View
    {
        return view('livewire.ad-script-list');
    }
}
