<?php

namespace TailwindLabs\HeroiconsFinder;

use NativePHPLauncher\Core\Plugin;
use TailwindLabs\HeroiconsFinder\Items\Icon;

class HeroiconsFinder implements Plugin
{
    public function keyword(): string
    {
        return 'hi';
    }

    public function handle(string $input): array
    {
        $path = __DIR__.'/../resources/svg/outline' . DIRECTORY_SEPARATOR . "*{$input}*";
        $filePathOccurrencesFound = glob($path);

        $results = [];

        foreach ($filePathOccurrencesFound as $filePath) {
            $results[] = new Icon($filePath);
        }

        return $results;
    }

    /**
     * Ejecuta la acción al seleccionar una opción.
     */
    public function execute(array $data): void
    {

    }
}
