<?php

namespace App\Livewire;

use App\PluginManager;
use Illuminate\Contracts\View\View;
use Livewire\Attributes\Computed;
use Livewire\Component;
use Native\Laravel\Facades\Clipboard;
use NativePHPLauncher\Core\Abstracts\ClipboardCopyable;

class Launcher extends Component
{
    public string $query = '';

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

    // computed

    #[Computed]
    public function trigger(): ?string
    {
        return explode(' ', trim($this->query))[0] ?? null;
    }

    #[Computed]
    public function arguments(): ?string
    {
        $query = trim($this->query);
        $trigger = trim($this->trigger);

        return trim($query === '' ? $query : array_reverse(explode($trigger, $query, 2))[0]);
    }

    #[Computed]
    public function items(): array
    {
        if (! is_null($this->trigger)) {
            $items = $this->pluginManager()->items($this->trigger, $this->arguments);

            $this->itemsCount = count($items);

            return $items;
        }

        return [];
    }

    // actions

    public function executeAction(int $index): void
    {
        /** @var \NativePHPLauncher\Core\Contracts\Items\ResultItem */
        $item = $this->items[$index];

        /** @var \NativePHPLauncher\Core\Contracts\Actions\Actionable */
        $action = $item->action();

        match (true) {
            $action instanceof ClipboardCopyable => Clipboard::text($item->render()),
            default => null,
        };
    }
}
