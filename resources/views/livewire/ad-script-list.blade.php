<div class="bg-white p-6 rounded-2xl shadow space-y-2">
    <h2 class="text-xl font-semibold">Ad Script Tasks</h2>

    @if($tasks->isEmpty())
        <div class="text-gray-500">No tasks yet.</div>
    @else
        <ul class="space-y-2">
            @foreach($tasks as $task)
                <li class="border p-2 rounded flex justify-between items-center">
                    <span>{{ $task->reference_script }}</span>
                    <span class="text-sm text-gray-600">{{ $task->status->value }}</span>
                </li>
            @endforeach
        </ul>
    @endif
</div>
