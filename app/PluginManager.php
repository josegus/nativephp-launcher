<?php

namespace App;

use Illuminate\Support\Collection;
use NativePHPLauncher\Core\Plugin;

class PluginManager
{
    /** @var array<string> */
    protected array $directories = [];

    /** @var array<string> */
    protected array $classes = [];

    /** @var array<string, \Launcher\Plugin> */
    protected array $plugins = [];

    public function __construct()
    {
        $this->loadDirectories();

        $this->loadClasses();

        // Cargar todas las clases de app/LauncherPlugins
        /* foreach (glob(base_path('_plugins') . '/*.php') as $file) {
            $class = $this->classFromFile($file);

            if (class_exists($class)) {
                $instance = app($class);

                if ($instance instanceof Plugin) {
                    $keyword = strtolower($instance->keyword());
                    $this->plugins[$keyword] = $instance;
                }
            }
        } */
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

    public function keywords(): array
    {
        // TODO: keywords should be retrieved inspecting the class content.. but what if the end user modify the keyword?
        return Collection::make($this->classes)
            ->map(function (string $class) {
                return (new $class())->keyWord();
            })
            ->toArray();
    }

    /**
     * Devuelve el plugin que coincide con el input del usuario
     */
    public function match(string $input): ?Plugin
    {
        $input = strtolower(trim($input));

        foreach ($this->plugins as $keyword => $plugin) {
            if (str_starts_with($input, $keyword)) {
                return $plugin;
            }
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
