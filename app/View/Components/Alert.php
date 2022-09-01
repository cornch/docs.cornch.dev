<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    private const THEME_STYLES = [
        'success' => [
            'border-green-700',
            'text-green-900',
            'bg-green-100',
        ],
    ];

    public function __construct(
        private readonly string $theme = 'primary',
    ) {
    }

    public function themeStyles(): array
    {
        return self::THEME_STYLES[$this->theme];
    }

    public function render(): View
    {
        return view('components.alert');
    }
}
