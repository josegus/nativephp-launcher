<?php

namespace App\NativePHP;

class Laravel
{
    protected string $signature = 'ld';

    protected string $logo = 'https://laravel.com/img/logomark.min.svg';

    protected array $commands = [
        ''
    ];

    public function handle(?string $query = null)
    {
        // Should be framework agnostic!
        $links = collect([
            ['text' => 'testing', 'value' => 'https://laravel.com/docs/testing'],
            ['text' => 'pest', 'value' => 'https://laravel.com/docs/pest'],
            ['text' => 'http', 'value' => 'https://laravel.com/docs/http'],
            ['text' => 'artisan', 'value' => 'https://laravel.com/docs/artisan'],
            ['text' => 'tinker', 'value' => 'https://laravel.com/docs/tinker'],
            ['text' => 'blade', 'value' => 'https://laravel.com/docs/blade'],
            ['text' => 'vite', 'value' => 'https://laravel.com/docs/vite'],
            ['text' => 'commands', 'value' => 'https://laravel.com/docs/commands'],
            ['text' => 'events', 'value' => 'https://laravel.com/docs/events'],
        ]);

        if (! $query) {
            return collect()->toArray();
        }

        return $links->filter(fn (array $item) => str($item['text'])->contains($query))->values()->toArray();
    }
}
