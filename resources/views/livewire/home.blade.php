<div x-data="{index: -1}" class="w-full h-full">
    <div class="w-full bg-red-500">
        <input
            wire:model.live.debounce.300ms="search"
            x-on:keyup.down="index++"
            class="w-full border-2 border-slate-400 p-4" type="text" placeholder="Search" autofocus
        >
    </div>
    {{-- <button x-trap="index===0" class="focus:outline-none focus:ring focus:ring-violet-300">this div must focus</button> --}}
    <div class="text-xs text-gray-300">
        <div>
            search is: {{ $search }}
        </div>
        <div>
            query is: {{ $this->query }}
        </div>
        <div>
            plugin is: {{ $this->plugin['file'] ?? 'undefined' }}
        </div>
    </div>

    {{-- Plugin handle --}}
    <div class="my-6">
        @if ($this->pluginHandle)
            @foreach ($this->pluginHandle as $item)
                <button
                    x-trap="index === {{ $loop->index }}"
                    x-on:keyup.down="index++"
                    x-on:keyup.up="index--"
                    wire:click="openUrl('{{ $item['value'] }}')"
                    class="w-full flex items-center justify-between py-4 | focus:outline-none focus:ring focus:ring-violet-300"
                >
                    <div class="space-x-3 flex items-center">
                        <img src="{{ $this->plugin['logo'] }}" class="w-6 h-6">
                        <span class="text-gray-800">{{ $item['text'] }}</span>
                    </div>

                    <span class="text-gray-400">{{ $item['value'] }}</span>
                </button>
            @endforeach
        @endif
    </div>

    <div class="mt-12 text-xs text-gray-300">
        Plugins: {{ $this->pluginsList->count() }}

        @foreach ($this->pluginsList as $plugin)
            <div>{{ $plugin['file'] }} -- Signature: {{ $plugin['signature'] }}</div>
        @endforeach
    </div>
</div>
