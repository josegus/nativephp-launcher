<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use NativePHPLauncher\Core\Plugin;
use Symfony\Component\Process\Process;

class PluginManager
{
    /**
     * Root folder of each plugin found.
     *
     * @var array<string>
     */
    protected array $directories = [];

    /**
     * Manifests found for each plugin.
     *
     * @var array<string>
     */
    protected array $manifests = [];

    public function __construct()
    {
        $this->loadDirectories();

        $this->loadManifests();
    }

    private function loadDirectories(): void
    {
        $this->directories = glob(base_path('_plugins/*'));
    }

    private function loadManifests(): void
    {
        foreach ($this->directories as $index => $directory) {
            $manifestExist = file_exists($directory . '/manifest.json');

            if ($manifestExist) {
                $this->manifests[] = $directory . '/manifest.json';
            } else {
                unset($this->directories[$index]);

                $this->directories = array_values($this->directories);
            }
        }
    }

    /**
     * Get the directories of plugins.
     *
     * @return array<string>
     */
    public function directories(): array
    {
        return $this->directories;
    }

    /**
     * Get the plugin main classes found.
     *
     * @return array<string>
     */
    public function manifests(): array
    {
        return $this->manifests;
    }

    /**
     * Get the list of triggers.
     *
     * @return array<int, string>
     */
    public function triggers(): array
    {
        /* return Collection::make($this->classes)
            ->mapWithKeys(function (string $class) {
                return [(new $class())->keyWord() => $class];
            })
            ->toArray(); */
        return ['ddd', 'asdf'];
    }

     /**
      * Get the plugins that match the given keyword.
      *
      * @param string $keyword
      * @return array<int, \NativePHPLauncher\Core\Plugin>
      */
    public function matches(string $keyword): array
    {
        $class = $this->hashMap()[$keyword] ?? null;

        if (! is_null($class)) {
            return [new $class()];
        }

        return [];
    }

    /**
     * Get the result items of all the plugins that match the trigger.
     *
     * @return array<int, array>
     */
    public function plugins(): array
    {
        /* if (empty($plugins = $this->matches())) {
            return [];
        }

        $items = [];

        foreach ($plugins as $plugin) {
            $items = $plugin->handle($arguments);
        }

        return $items; */

        $plugins = [];

        foreach ($this->manifests as $manifestPath) {
            $pluginDir = dirname($manifestPath);
            $manifest = json_decode(file_get_contents($manifestPath), true);
            $command = $manifest['command'];
            $commandParts = explode(' ', $command); // ['php', 'main.php']
            $process = new Process($commandParts, $pluginDir);
            $process->run();

            // Capturar salida
            if ($process->isSuccessful()) {
                $plugins[] = json_decode($process->getOutput(), true);
            } else {
                //echo $process->getErrorOutput();
            }
        }

        return $plugins;
    }

    /**
     * Undocumented function
     *
     * @param string $keyword
     * @param string $arguments
     * @return array<string>
     */
    public function output(string $keyword, string $arguments = ''): array
    {
        if (empty($items = $this->items($keyword, $arguments))) {
            return [];
        }

        $output = [];

        foreach ($items as $item) {
            $output[] = $item->render();
        }

        return $output;
    }
}
