<?php

namespace Ignite\Workflow;

class Workflow
{
    /**
     * Items show as the result of the input search.
     *
     * @var array<int, array[icon, title, description, content, action]>
     */
    protected array $items = [];

    public function input(): ?string
    {
        return getenv('IGNITE_ARGUMENTS') ?: null;
    }

    /**
     * Get the list of items that will be shown as the result of the search.
     *
     * @param array<int, array[icon, title, description, content, action]> $items
     * @return self
     */
    public function items(array $items): self
    {
        $this->items = $items;

        return $this;
    }

    /**
     * Get the encoded output.
     *
     * @return string
     */
    public function output(): string
    {
        $output = [
            'items' => $this->items,
        ];

        return json_encode($output);
    }
}
