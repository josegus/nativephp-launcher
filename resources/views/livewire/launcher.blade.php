<div x-data="{ index: -1 }" class="w-full">
    <input
        wire:model.live.debounce.200ms="query"
        x-on:keyup.down="index++"
        type="text"
        class="w-full bg-white outline-none border border-gray-500 rounded-xs p-4"
        placeholder="Search"
        autofocus
    >
    <div>
        <span>query: {{ $query }}</span>|
        <span x-text="index"></span>
    </div>

    <div>
        Commands:
        <pre>
            @json($this->keywords)
        </pre>
    </div>

    <section>
        <ul>
            @foreach ($this->output as $item)
                <li
                    x-trap="index === {{ $loop->index }}"
                    x-on:keyup.down="index++"
                    x-on:keyup.up="index--"
                    wire:key="item-{{ $loop->index }}"
                    wire:click="executeAction({{ $loop->index }})"
                    class="hover:bg-gray-200 border px-6 py-4"
                >
                    {!! $item !!}
                </li>
            @endforeach
        </ul>
        @unless (empty($this->output))
            <span class="inline-block mt-2 text-sm text-gray-600">Results found: {{ count($this->output) }}</span>
        @endunless
    </section>
</div>
