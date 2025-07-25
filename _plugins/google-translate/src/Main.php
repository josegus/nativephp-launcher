<?php

namespace Ignite\GoogleTranslate;

use NativePHPLauncher\Core\Plugin;
use Stichoza\GoogleTranslate\GoogleTranslate;

class Main implements Plugin
{
    public function keyword(): string
    {
        return 'gt';
    }

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

        $results = [
            new TranslateItem($translatedText)
        ];

        return $results;
    }
}
