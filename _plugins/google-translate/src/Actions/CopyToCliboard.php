<?php

namespace Ignite\GoogleTranslate\Actions;

use NativePHPLauncher\Core\Abstracts\ClipboardCopyable;

class CopyToCliboard extends ClipboardCopyable
{
    public function __construct(protected string $text)
    {
        //
    }
    public function content(): string
    {
        return $this->text;
    }
}
