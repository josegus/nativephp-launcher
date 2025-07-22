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
        // $input => cap
        $path = __DIR__.'/../resources/svg/outline' . DIRECTORY_SEPARATOR . "*{$input}*";
        $filePathOccurrencesFound = glob($path);

        $output = [];

        foreach ($filePathOccurrencesFound as $filePath) {
            // $svg = file_get_contents($filePath);

            // /* $svg = preg_replace_callback(
            //     '/class="([^"]*)"/',
            //     fn ($matches) => 'class="' . trim($matches[1] . ' size-24') . '"',
            //     $svg
            // ); */

            // $svg = preg_replace(
            //     '/<svg\b(?![^>]*\bclass=)/',
            //     '<svg class="size-12"',
            //     $svg
            // );

            // $output[] = <<<HTML
            //     <div>$svg</div>
            // HTML;

            $output[] = new Icon($filePath);
        }

        return $output;
    }

    /**
     * Ejecuta la acción al seleccionar una opción.
     */
    public function execute(array $data): void
    {

    }
}
