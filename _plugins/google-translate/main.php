<?php

use Ignite\GoogleTranslate\Main;
use Ignite\Workflow\Workflow;

require __DIR__ . '/vendor/autoload.php';

$workflow = new Workflow;

// find
$input = $workflow->input();
$main = new Main;
$items = $main->handle($input);

// arrange
$workflow->items($items);

// print
echo $workflow->output();
