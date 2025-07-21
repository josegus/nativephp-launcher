<div class="w-full">
    <input wire:model.live.debounce.200ms="query" type="text" class="w-full bg-white outline-none border border-gray-500 rounded-xs p-4" placeholder="Search" autofocus>
    <span>query: {{ $query }}</span>

    <div>
        Commands:
        <pre>
            @json($this->keywords)
        </pre>
    </div>

    <section>
        <ul>
            @foreach ($output as $item)
                <li wire:key="item-{{ $loop->index }}" class="hover:bg-gray-200 border px-6 py-4">{!! $item !!}</li>
            @endforeach
        </ul>
    </section>
</div>
