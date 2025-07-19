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
    public string $query = '';

    protected PluginManager $pluginManager;

    public function mount(): void
    {
        $this->pluginManager = new PluginManager;
    }

    public function render(): View
    {
        return view('livewire.launcher');
    }

    // computed

    #[Computed(persist: true)]
    public function keywords(): array
    {
        return $this->pluginManager->keywords();
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
