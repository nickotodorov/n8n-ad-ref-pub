<div class="space-y-8"> {{-- SINGLE root element --}}
    <div class="bg-white p-6 rounded-2xl shadow space-y-4">
        <h2 class="text-xl font-semibold">Create Ad Script Task</h2>

        @if($message)
            <div class="p-2 bg-green-100 text-green-700 rounded">{{ $message }}</div>
        @endif

        <form wire:submit.prevent="submit" class="space-y-4">
            <div>
                <label class="block text-sm font-medium text-gray-700">Reference Script</label>
                <textarea wire:model="reference_script" rows="4" class="w-full border-gray-300 rounded-lg"></textarea>
                @error('reference_script')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <div>
                <label class="block text-sm font-medium text-gray-700">Outcome Description</label>
                <textarea wire:model="outcome_description" rows="3" class="w-full border-gray-300 rounded-lg"></textarea>
                @error('outcome_description')<span class="text-red-500 text-sm">{{ $message }}</span>@enderror
            </div>

            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded hover:bg-indigo-700">
                Submit
            </button>
        </form>
    </div>
</div>
