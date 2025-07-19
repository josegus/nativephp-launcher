<div class="w-full">
    <input wire:model.live.debounce.200ms="query" type="text" class="w-full bg-white outline-none border border-gray-500 rounded-xs p-4" placeholder="Search" autofocus>
    <span>query: {{ $query }}</span>

    <div>
        Commands:
        <pre>
            @json($this->keywords)
        </pre>
    </div>
</div>
