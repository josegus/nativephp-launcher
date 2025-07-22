<?php

namespace NativePHPLauncher\Core\Contracts\Items;

use NativePHPLauncher\Core\Contracts\Actions\Actionable;

interface ResultItem
{
    public function name(): string;

    public function description(): string;

    public function render(): string;

    public function action(): Actionable;
}
