<div x-data="{
    index: -1,
    max: $wire.entangle('itemsCount'),
    showDetails: false
}" class="w-full">
    <section class="text-sm mb-4">
        <button x-on:click="showDetails = !showDetails" class="cursor-pointer">
            <span x-show="showDetails">Hide</span>
            <span x-show="showDetails === false">Show</span>
            details
        </button>
        <ul x-show="showDetails" class="list-disc list-inside border border-gray-400 p-2 bg-white">
            <li>index: <span x-text="index"></span></li>
            <li>max: <span x-text="max"></span></li>
            <li>trigger: {{ $trigger ?: 'n/a' }}</li>
            <li>arguments: {{ $arguments ?: 'n/a' }}</li>
            <li>
                directories:
                <pre class="ml-4">@json($this->directories, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES)</pre>
            </li>
        </ul>
    </section>

    <input
        wire:model.live.debounce.400ms="query"
        x-on:keyup.down="index < max - 1 ? index++ : null"
        x-on:keyup.up="index > 0 ? index-- : null"
        type="text"
        class="w-full bg-white outline-none border border-gray-500 rounded-xs p-4 fixed"
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
