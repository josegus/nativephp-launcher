<?php

namespace Ignite\GoogleTranslate;

class TranslateItem
{
    public ?string $translatedText = null;

    public function __construct(string $translatedtext = '')
    {
        $this->translatedText = $translatedtext;
    }

    public function name(): string
    {
        return 'Google Translate';
    }

    public function description(): string
    {
        return $this->translatedText;
    }

    // This is equivalent to the icon
    public function render(): string
    {
        // TODO: Fix icon
        //$icon = __DIR__.'/../resources/images/icon.png';

        return <<<HTML
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Google_Translate_logo.svg/960px-Google_Translate_logo.svg.png">
        HTML;
    }
}
