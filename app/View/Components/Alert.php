<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class Alert extends Component
{
    private const WRAPPER_THEME_STYLES = [
        'warning' => [
            'border-yellow-500',
        ],
        'success' => [
            'border-green-500',
        ],
    ];

    private const ICON_WRAPPER_THEME_STYLES = [
        'warning' => [
            'bg-yellow-500',
        ],
        'success' => [
            'bg-green-500',
        ],
    ];

    public function __construct(
        private readonly string $theme = 'primary',
        private readonly ?string $icon = null,
    ) {}

    public function wrapperStyles(): array
    {
        return self::WRAPPER_THEME_STYLES[$this->theme] ?? [];
    }

    public function titleThemeStyles(): array
    {
        return [];
    }

    public function iconWrapperStyles(): array
    {
        return [
            'flex justify-center items-center',
            'px-6',
            'rounded-l',
            'text-white/70',
            ...(self::ICON_WRAPPER_THEME_STYLES[$this->theme] ?? []),
        ];
    }

    public function icon(): string
    {
        return $this->icon ?? match ($this->theme) {
            'warning' => 'heroicon-s-exclamation-triangle',
            'success' => 'heroicon-s-check-circle',
        };
    }

    public function render(): View
    {
        return view('components.alert');
    }
}
