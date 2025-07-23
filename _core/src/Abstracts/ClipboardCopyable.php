<?php

namespace NativePHPLauncher\Core\Abstracts;

use NativePHPLauncher\Core\Contracts\Actions\Actionable;

abstract class ClipboardCopyable implements Actionable
{
    abstract public function content(): string;
}
