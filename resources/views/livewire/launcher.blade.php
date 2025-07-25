<div x-data="{ index: -1, max: $wire.entangle('itemsCount') }" class="w-full">
    <section>
        <div>index: <span x-text="index"></span></div>
        <div>max: <span x-text="max"></span></div>
        <div>trigger: {{ $this->trigger ?: 'n/a' }}</div>
        <div>arguments: {{ $this->arguments ?: 'n/a' }}</div>
    </section>

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
            @foreach ($this->items as $item)
                <li
                    x-trap="index === {{ $loop->index }}"
                    wire:key="item-{{ $loop->index }}"
                    wire:click="executeAction({{ $loop->index }})"
                    class="flex space-x-4 px-4 py-2 hover:bg-gray-300 cursor-pointer"
                    :class="index === {{ $loop->index }} ? 'bg-gray-300' : ''"
                >
                    <div class="size-6">
                        {!! $item->render() !!}
                    </div>
                    <div>
                        <div>{{ $item->name() }}</div>
                        <div class="text-sm text-gray-500">{{ $item->description() }}</div>
                    </div>
                </li>
            @endforeach
        </ul>
        @unless (empty($this->trigger))
            <span class="inline-block mt-2 text-sm text-gray-600">Results found: {{ count($this->items) }}</span>
        @endunless
    </section>
</div>
