<?php

namespace Ignite\GoogleTranslate;

use Ignite\Workflow\Enums\Actions;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Main
{
    /**
     * Devuelve los resultados que el usuario puede ver al escribir.
     *
     * @return array<int, \NativePHPLauncher\Core\Contracts\Items\ResultItem>
     */
    public function handle(string $input): array
    {
        $tr = new GoogleTranslate('en'); // Translates into English

        // TODO: Catch exceptions
        $translatedText = $tr->translate($input);

        $item = new TranslateItem($translatedText);

        $results[] = [
            'icon' => $item->render(),
            'title' => $item->name(),
            'description' => $item->description(),
            'content' => $item->render(),
            'action' => Actions::COPY_TO_CLIPBOARD,
        ];

        return $results;
    }
}
