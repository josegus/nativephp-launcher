<?php

namespace TailwindLabs\HeroiconsFinder;

use Ignite\Workflow\Enums\Actions;
use NativePHPLauncher\Core\Plugin;
use TailwindLabs\HeroiconsFinder\Items\HeroIconResult;

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
            $results[] = new HeroIconResult($filePath);
        }

        return $results;
    }

    public function results(string $input): array
    {
        $path = __DIR__.'/../resources/svg/outline' . DIRECTORY_SEPARATOR . "*{$input}*";
        $filePathOccurrencesFound = glob($path);

        $results = [];

        foreach ($filePathOccurrencesFound as $filePath) {
            $item = new HeroIconResult($filePath);

            $results[] = [
                'icon' => $item->render(),
                'title' => $item->name(),
                'content' => $item->description(),
                'action' => Actions::COPY_TO_CLIPBOARD,
            ];
        }

        return $results;
    }
}
