<?php

namespace App\Livewire;

use App\PluginManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Native\Laravel\Facades\Clipboard;
use Native\Laravel\Facades\Shell;
use NativePHPLauncher\Core\Actions\CopyToClipboard;
use ReflectionClass;
use TailwindLabs\HeroiconsFinder\HeroiconsFinder;

class Launcher extends Component
{
    public string $query = 'hi user';

    /**
     * List of plugins found for the given query input.
     *
     * @var array<int, \NativePHPLauncher\Core\Plugin>
     */
    //public array $plugins = [];

    //protected ?PluginManager $pluginManager = null;

    public function mount(): void
    {
        //$this->pluginManager = new PluginManager;
        //$this->pluginManager = app(PluginManager::class);
    }

    public function render(): View
    {
        return view('livewire.launcher');
    }

    // helpers

    protected function pluginManager(): PluginManager
    {
        return app(PluginManager::class);
    }

    // computed

    #[Computed(persist: true)]
    public function keywords(): array
    {
        return $this->pluginManager()->keywords();
    }

    #[Computed]
    public function arguments(): string
    {
        return 'user';
    }

    #[Computed]
    public function plugins(): array
    {
        return [$this->pluginManager()->match($this->query)];
    }

    /**
     * Items.
     *
     * @return array<int, \NativePHPLauncher\Core\Contracts\Items\ResultItem>
     */
    #[Computed]
    public function items(): array
    {
        if (empty($this->plugins)) {
            return [];
        }

        $items = [];

        foreach ($this->plugins as $plugin) {
            // TODO: Must be fixed, it will return an array for each plugin
            $items = $plugin->handle($this->arguments);
        }

        return $items;
    }

    #[Computed]
    public function output(): array
    {
        if (empty($this->plugins)) {
            return [];
        }

        $output = [];

        foreach ($this->items as $item) {
            $output[] = $item->render();
        }

        return $output;
    }

    // hooks

    public function updatedQuery(): void
    {
        //$this->plugins = [$this->pluginManager()->match($this->query)];

        /* if (empty($plugins)) {
            return;
        }

        // Get the ResultItems from the plugins
        $resultItems = $plugin->handle($argument);

        $output = [];

        foreach ($resultItems as $item) {
            $output[] = $item->render();
        }

        $this->output = $output;
         */
    }

    // actions

    public function executeAction(int $index): void
    {
        /** @var \NativePHPLauncher\Core\Contracts\Items\ResultItem */
        $item = $this->items[$index];
        $action = $item->action();

        match (true) {
            $action instanceof CopyToClipboard => Clipboard::text($item->render()),
            default => null,
        };
    }

    public function openUrl(): void
    {
        $trigger = Str::of($this->query)->trim()->before(' ');
        $argument = Str::of($this->query)->trim()->after(' ');

        $url = match ($trigger) {
            'g' => 'https://google.com/search?='.$argument,
            'wiki' => 'https://en.wikipedia.org/wiki/'.$argument,
            default => null,
        };

        if ($url) {
            Shell::openExternal($url);
        }
    }
}
