<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use NativePHPLauncher\Core\Plugin;

class PluginManager
{
    /**
     * Root folder of each plugin found.
     *
     * @var array<string>
     */
    protected array $directories = [];

    /**
     * Main classes found for each plugin, including full namespace.
     *
     * @var array<string>
     */
    protected array $classes = [];

    public function __construct()
    {
        $this->loadDirectories();

        $this->loadClasses();
    }

    private function loadDirectories(): void
    {
        $this->directories = glob(base_path('_plugins/*'));
    }

    private function loadClasses(): void
    {
        foreach ($this->directories as $directory) {
            $classes = glob($directory . '/src/*.php');

            if (! empty($classes)) {
                $this->classes[] = $this->getFullClassNameFromFile($classes[0]);
            }
        }
    }

    /**
     * Inspect the content of a .php file and get the full
     * class name (namespace + class) of the file.
     *
     * @param string $path
     * @return string|null
     */
    private function getFullClassNameFromFile(string $path): ?string
    {
        $contents = file_get_contents($path);

        $namespace = null;
        $class = null;

        if (preg_match('/namespace\s+(.+?);/', $contents, $matches)) {
            $namespace = trim($matches[1]);
        }

        if (preg_match('/class\s+(\w+)/', $contents, $matches)) {
            $class = trim($matches[1]);
        }

        if ($class) {
            return $namespace ? "$namespace\\$class" : $class;
        }

        return null;
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
    public function classes(): array
    {
        return $this->classes;
    }

    /**
     * Get the list of keywords with its respective trigger class.
     *
     * @return array<string, \NativePHPLauncher\Core\Plugin>
     */
    public function hashMap(): array
    {
        return Collection::make($this->classes)
            ->mapWithKeys(function (string $class) {
                return [(new $class())->keyWord() => $class];
            })
            ->toArray();
    }

    /**
     * Get the list of keywords of all the plugins found.
     *
     * @return array<int, string>
     */
    public function keywords(): array
    {
        // TODO: keywords should be retrieved inspecting the class content.. but what if the end user modify the keyword?
        return array_keys($this->hashMap());
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
     * Get the ResultItems of all the plugins that match the given keyword.
     *
     * @param string $keyword
     * @param string $arguments
     * @return array<int, \NativePHPLauncher\Core\Contracts\Items\ResultItem>
     */
    public function items(string $keyword, string $arguments = ''): array
    {
        if (empty($plugins = $this->matches($keyword))) {
            return [];
        }

        $items = [];

        foreach ($plugins as $plugin) {
            $items = $plugin->handle($arguments);
        }

        return $items;
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
