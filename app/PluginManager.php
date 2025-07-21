<?php

namespace App;

use Illuminate\Support\Collection;
use Illuminate\Support\Str;
use NativePHPLauncher\Core\Plugin;

class PluginManager
{
    /**
     * Directories (folders) found that contain the root folder of each plugin.
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

    /** @var array<string, \Launcher\Plugin> */
    protected array $plugins = [];

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

    public function classes(): array
    {
        return $this->classes;
    }

    /**
     * Get the list of keywords with its respective trigger class.
     *
     * @return array<string, \NativePHPLauncher\Core\Plugin>
     */
    public function keywordsWithClass(): array
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
        return array_keys($this->keywordsWithClass());
    }

    /**
     * Devuelve el plugin que coincide con el input del usuario
     */
    public function match(string $input): ?Plugin
    {
        $input = strtolower(trim($input));

        $keyword = Str::of($input)->before(' ')->toString();
        $arguments = Str::of($input)->after(' ')->toString(); // TODO: it'll have the same value of $keyword if $input doesn't contain a space to separate the arguments

        $class = $this->keywordsWithClass()[$keyword] ?? null;

        if (! is_null($class)) {
            return new $class();
        }

        return null;
    }

    /**
     * Retorna todos los plugins disponibles
     */
    public function all(): array
    {
        return $this->plugins;
    }
}
