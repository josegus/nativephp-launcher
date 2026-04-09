<?php

namespace TailwindLabs\HeroiconsFinder\Support;

class HeroIconResult
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
            '<svg __class="size-12"',
            $svgContent
        );

        return <<<HTML
            $svgContent
        HTML;
    }
}
