<?php

namespace TailwindLabs\HeroiconsFinder\Items;

use NativePHPLauncher\Core\Actions\CopyToClipboard;
use NativePHPLauncher\Core\Contracts\Actions\Actionable;
use NativePHPLauncher\Core\Contracts\Items\ResultItem;

class Icon implements ResultItem
{
    protected ?string $filePath = null;

    public function __construct(string $path)
    {
        $this->filePath = $path;
    }

    public function name(): string
    {
        return 'my icon';
    }

    public function description(): string
    {
        return 'my description';
    }

    public function render(): string
    {
        $svg = file_get_contents($this->filePath);

        /* $svg = preg_replace_callback(
            '/class="([^"]*)"/',
            fn ($matches) => 'class="' . trim($matches[1] . ' size-24') . '"',
            $svg
        ); */

        $svg = preg_replace(
            '/<svg\b(?![^>]*\bclass=)/',
            '<svg class="size-12"',
            $svg
        );

        return <<<HTML
            <div>$svg</div>
        HTML;
    }

    public function action(): Actionable
    {
        return new CopyToClipboard;
    }
}
