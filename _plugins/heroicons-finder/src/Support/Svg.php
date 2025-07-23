<?php

namespace TailwindLabs\HeroiconsFinder\Support;

class Svg
{
    protected ?string $path = null;

    public function __construct(string $path)
    {
        $this->path = $path;
    }

    public function filename(): string
    {
        return pathinfo($this->path, PATHINFO_FILENAME);
    }

    public function content(): string
    {
        $content = file_get_contents($this->path);

        return <<<HTML
            $content
        HTML;
    }
}
