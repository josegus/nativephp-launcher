<?php

namespace App\Livewire;

use App\PluginManager;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Native\Desktop\Clipboard as DesktopClipboard;
use Native\Desktop\Facades\Clipboard;

class Launcher extends Component
{
    public string $query = '';
    public string $trigger = '';
    public ?string $arguments = null;
    public array $items = [];
    public int $itemsCount = 0;

    public function render(): View
    {
        return view('livewire.launcher');
    }

    // helpers

    protected function pluginManager(): PluginManager
    {
        return app(PluginManager::class);
    }

    protected function setTrigger(): void
    {
        $this->trigger = explode(' ', trim($this->query))[0] ?? null;
    }

    protected function setArguments(): void
    {
        $query = trim($this->query);
        $trigger = trim($this->trigger);

        $arguments = trim($query === '' ? $query : array_reverse(explode($trigger, $query, 2))[0]);

        if (! $arguments) {
            $this->arguments = null;
        } else {
            $this->arguments = $arguments;
        }

        putenv("IGNITE_ARGUMENTS=$arguments");
    }

    protected function setItems(): void
    {
        if (is_null($this->trigger) || empty($this->trigger)) {
            $this->items = [];

            return;
        }

        $plugins = $this->pluginManager()->plugins();

        $items = collect($plugins)->pluck('items')->flatten(1)->toArray();

        $this->items = $items;
        $this->itemsCount = count($items);
    }

    // hooks

    public function updatedQuery(): void
    {
        $this->setTrigger();

        $this->setArguments();

        $this->setItems();
    }

    // public function updatedArguments(?string $arguments): void
    // {
    //     putenv("IGNITE_ARGUMENTS=$arguments");
    // }

    // computed

    // #[Computed]
    // public function trigger(): ?string
    // {
    //     return explode(' ', trim($this->query))[0] ?? null;
    // }

    // #[Computed]
    // public function arguments(): ?string
    // {
    //     $query = trim($this->query);
    //     $trigger = trim($this->trigger);

    //     $arguments = trim($query === '' ? $query : array_reverse(explode($trigger, $query, 2))[0]);

    //     if (! $arguments) {
    //         return null;
    //     }

    //     putenv("IGNITE_ARGUMENTS=$arguments");

    //     return $arguments;
    // }

    #[Computed(persist: true)]
    public function directories(): array
    {
        return $this->pluginManager()->directories();
    }

    // #[Computed]
    // public function items(): array
    // {
    //     if (is_null($this->trigger) || empty($this->trigger)) {
    //         return [];
    //     }

    //     $plugins = $this->pluginManager()->plugins();

    //     $items = collect($plugins)->pluck('items')->flatten(1)->toArray();

    //     $this->itemsCount = count($items);

    //     return $items;
    // }

    // actions

    public function executeAction(int $index): void
    {
        if ($index < 0) {
            return;
        }

        if (empty($this->items)) {
            return;
        }

        $item = $this->items[$index];

        match (true) {
            $item['action'] === 'COPY_TO_CLIPBOARD' => Clipboard::text($item['content']),
            default => null,
        };
    }
}
