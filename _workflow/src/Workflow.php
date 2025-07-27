<?php

namespace Ignite\Workflow;

class Workflow
{
    /**
     * Undocumented variable
     *
     * @var array<int, array[icon, title, content, action]>
     */
    protected array $items = [];

    public function input(): ?string
    {
        return getenv('IGNITE_ARGUMENTS') ?: null;
    }

    /**
     * {icon, title, content, action}
     *
     * @param array<int, string> $items
     * @return self
     */
    public function items(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    public function output(): string
    {
        $output = [
            'items' => $this->items,
        ];

        return json_encode($output);
    }
}
