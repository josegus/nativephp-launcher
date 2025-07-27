<?php

namespace TailwindLabs\HeroiconsFinder\Items;

use NativePHPLauncher\Core\Contracts\Actions\Actionable;
use NativePHPLauncher\Core\Contracts\Items\ResultItem;
use TailwindLabs\HeroiconsFinder\Actions\CopyToClipboard;
use TailwindLabs\HeroiconsFinder\Support\Svg;

class HeroIconResult implements ResultItem
{
    protected ?string $path = null;
    protected ?Svg $svg = null;

    public function __construct(string $path)
    {
        $this->path = $path;

        $this->svg = new Svg($path);
    }

    public function name(): string
    {
        return $this->svg->filename();
    }

    public function description(): string
    {
        return basename($this->path);
    }

    public function render(): string
    {
        $svgContent = $this->svg->content();

        /* $svgContent = preg_replace_callback(
            '/class="([^"]*)"/',
            fn ($matches) => 'class="' . trim($matches[1] . ' size-24') . '"',
            $svgContent
        ); */

        $svgContent = preg_replace(
            '/<svg\b(?![^>]*\bclass=)/',
            '<svg class="size-12"',
            $svgContent
        );

        return <<<HTML
            $svgContent
        HTML;
    }

    public function action(): Actionable
    {
        return new CopyToClipboard($this->svg);
    }
}
