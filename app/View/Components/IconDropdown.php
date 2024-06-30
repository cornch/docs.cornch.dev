<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

final class IconDropdown extends Component
{
    private const SIZE_STYLES = [
        'md' => [
            'icon-wrapper' => 'pl-4',
            'chevron-wrapper' => 'right-4',
            'chevron' => 'w-4 h-4',
            'select' => 'pr-8 py-1',
            'noscript' => 'mx-2 px-2 py-1',
            'summary' => 'px-2',
            'noscript-ul' => 'mt-1 mr-2 px-2 py-1',
        ],
        'sm' => [
            'icon-wrapper' => 'pl-3',
            'chevron-wrapper' => 'right-3',
            'chevron' => 'w-3 h-3',
            'select' => 'pr-8 text-sm py-1',
            'noscript' => 'mx-1 px-1 py-1',
            'summary' => 'px-2 text-sm',
            'noscript-ul' => 'mt-1 mr-2 px-2 py-1',
        ],
    ];

    public function __construct(
        public readonly string $size = 'md',
    ) {}

    public function sizeStyle($component): string
    {
        return self::SIZE_STYLES[$this->size][$component];
    }

    public function render(): View
    {
        return view('components.icon-dropdown');
    }
}
