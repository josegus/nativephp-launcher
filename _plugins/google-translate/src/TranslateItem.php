<?php

namespace Ignite\GoogleTranslate;

use Ignite\GoogleTranslate\Actions\CopyToCliboard;
use NativePHPLauncher\Core\Contracts\Actions\Actionable;
use NativePHPLauncher\Core\Contracts\Items\ResultItem;

class TranslateItem implements ResultItem
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
        $icon = __DIR__.'/../resources/images/icon.png';

        return <<<HTML
            <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/d/d7/Google_Translate_logo.svg/512px-Google_Translate_logo.svg.png">
            <!-- <img src="$icon"> -->
        HTML;
    }

    public function action(): Actionable
    {
        return new CopyToCliboard($this->translatedText);
    }
}
