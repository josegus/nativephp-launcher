<?php

namespace TailwindLabs\HeroiconsFinder;

use NativePHPLauncher\Core\Plugin;

class HeroiconsFinder implements Plugin
{
    public function keyword(): string
    {
        return 'hi';
    }

    public function handle(string $input): array
    {
        return [];
    }

    /**
     * Ejecuta la acción al seleccionar una opción.
     */
    public function execute(array $data): void
    {

    }
}
