<?php

namespace TailwindLabs\HeroiconsFinder\Actions;

use NativePHPLauncher\Core\Abstracts\ClipboardCopyable;
use TailwindLabs\HeroiconsFinder\Support\Svg;

class CopyToClipboard extends ClipboardCopyable
{
    protected Svg $svg;

    public function __construct(Svg $svg)
    {
        $this->svg = $svg;
    }

    public function content(): string
    {
        return $this->svg->content();
    }
}
