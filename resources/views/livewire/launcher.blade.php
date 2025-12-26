<div x-data="{ index: -1, max: $wire.entangle('itemsCount') }" class="w-full">
    <section>
        <div>index: <span x-text="index"></span></div>
        <div>max: <span x-text="max"></span></div>
        <div>trigger: {{ $trigger ?: 'n/a' }}</div>
        <div>arguments: {{ $arguments ?: 'n/a' }}</div>
        <div>
            directories:

            <pre>@json($this->directories, JSON_PRETTY_PRINT)</pre>
        </div>
    </section>
    <pre>@json($items ?? ['def'])</pre>
    <div>{{ count($items) }}</div>

    <input
        wire:model.live.debounce.400ms="query"
        x-on:keyup.down="index < max - 1 ? index++ : null"
        x-on:keyup.up="index > 0 ? index-- : null"
        type="text"
        class="w-full bg-white outline-none border border-gray-500 rounded-xs p-4"
        placeholder="Search"
        autofocus
    >

    <section>
        <ul>
            @foreach ($items as $item)
                <li
                    x-trap="index === {{ $loop->index }}"
                    wire:key="item-{{ $loop->index }}"
                    wire:click="executeAction({{ $loop->index }})"
                    class="flex space-x-4 px-4 py-2 hover:bg-gray-300 cursor-pointer"
                    :class="index === {{ $loop->index }} ? 'bg-gray-300' : ''"
                >
                    <div class="max-h-6 max-w-6 size-auto border">
                        {!! $item['icon'] !!}
                    </div>
                    <div>
                        <div>{{ $item['title'] }}</div>
                        <div class="text-sm text-gray-500">{{ $item['description'] ?? '' }}</div>
                    </div>
                </li>
            @endforeach
        </ul>
        @unless (empty($this->trigger))
            <span class="inline-block mt-2 text-sm text-gray-600">Results found: {{ count($items) }}</span>
        @endunless
    </section>
</div>
