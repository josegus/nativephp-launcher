<?php

namespace App\Livewire;

use App\PluginManager;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Str;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Native\Laravel\Facades\Shell;
use ReflectionClass;
use TailwindLabs\HeroiconsFinder\HeroiconsFinder;

class Launcher extends Component
{
    public string $query = 'hi user';

    public array $output = [];

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

    // hooks

    public function updatedQuery(): void
    {
        $plugin = $this->pluginManager()->match($this->query);

        if (is_null($plugin)) {
            return;
        }

        $argument = 'user';

        $this->output = $plugin->handle($argument);
    }

    // actions

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
