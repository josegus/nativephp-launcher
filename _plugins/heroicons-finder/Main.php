<?php

use Ignite\Workflow\Workflow;
use TailwindLabs\HeroiconsFinder\HeroiconsFinder;

require __DIR__ . '/vendor/autoload.php';

$workflow = new Workflow;

// find
$input = $workflow->input();
$finder = new HeroiconsFinder;
$items = $finder->results($input);

// arrange
$workflow->items($items);

// print
echo $workflow->output();
