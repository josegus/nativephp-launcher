<?php

namespace TailwindLabs\HeroiconsFinder;

use Ignite\Workflow\Enums\Actions;
use NativePHPLauncher\Core\Plugin;
use TailwindLabs\HeroiconsFinder\Items\HeroIconResult;

class HeroiconsFinder
{
    public function __getIcons(): array
    {
        $results = [];
        $results[] = [
            'icon' => '$item->render()',
            'title' => '$item->name()',
            'content' => '$item->description()',
            'action' => 'Actions::COPY_TO_CLIPBOARD',
        ];
        $results[] = [
            'icon' => '$item->render()',
            'title' => '$item->name()',
            'content' => '$item->description()',
            'action' => 'Actions::COPY_TO_CLIPBOARD',
        ];

        return $results;
    }

    public function getIcons(string $input): array
    {
        try {
            $path = __DIR__.'/../resources/svg/outline' . DIRECTORY_SEPARATOR . "*{$input}*";
            $filePathOccurrencesFound = glob($path);

            $results = [];

            foreach ($filePathOccurrencesFound as $filePath) {
                $item = new HeroIconResult($filePath);

                $results[] = [
                    'icon' => $item->render(),
                    'title' => $item->name(),
                    'description' => $item->description(),
                    'content' => $item->render(),
                    'action' => Actions::COPY_TO_CLIPBOARD,
                ];
            }

            return $results;
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
