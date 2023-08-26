<?php

namespace App\Livewire;

use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use ReflectionClass;

class Home extends Component
{
    public string $search = '';

    protected const PLUGINS_PATH = '/Users/gustavovasquez/Sites/nativephp/app/NativePHP';

    public function render()
    {
        return view('livewire.home');
    }

    // plugins

    public function getPluginsListProperty()
    {
        // External file path can be fixed generating a symlink
        $files = collect(scandir(self::PLUGINS_PATH))->reject(fn (string $file) => in_array($file, ['.', '..']))
            ->map(function (string $file) {
                $class = "App\\NativePHP\\".str($file)->before('.php');

                return [
                    'file' => $file,
                    'signature' => (new ReflectionClass('App\\NativePHP\\'.str($file)->before('.php')))->getDefaultProperties()['signature'],
                    'logo' => (new ReflectionClass('App\\NativePHP\\'.str($file)->before('.php')))->getDefaultProperties()['logo'],
                    'instance' => new $class(),
                ];
            });

        return $files;
    }

    public function getPluginProperty(): array|null
    {
        if (! $this->search) {
            return [];
        }

        return $this->pluginsList->filter(fn (array $plugin) => str($this->search)->before(' ')->toString() === $plugin['signature'])->first() ?? null;
    }

    public function getQueryProperty()
    {
        return str($this->search)->after(' ');
    }

    public function getPluginHandleProperty(): array|null
    {
        if (! $this->plugin) {
            return null;
        }

        return $this->plugin['instance']->handle($this->query);
    }

    public function openUrl(string $url)
    {
        //return $this->redirect($url);
        return redirect()->away($url);
    }
}
