<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Button extends Component
{
    private const THEME_STYLES = [
        'primary' => [
            'border-zinc-300 dark:border-zinc-500',
            'text-zinc-700 dark:text-zinc-100',
            'bg-white hover:bg-zinc-100',
            'dark:bg-zinc-800 dark:hover:bg-zinc-700',
        ],
        'success' => [
            'border-green-800',
            'text-white',
            'bg-green-600 hover:bg-green-500',
            'dark:bg-green-700 dark:hover:bg-green-600',
        ],
    ];

    public function __construct(
        private readonly string $theme = 'primary',
    ) {
    }

    public function themeStyles(): array
    {
        return self::THEME_STYLES[$this->theme] ?? self::THEME_STYLES['primary'];
    }

    public function render(): View
    {
        return view('components.button');
    }
}
