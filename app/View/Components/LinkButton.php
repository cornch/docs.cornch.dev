<?php

namespace App\View\Components;

use Illuminate\Contracts\View\View;

final class LinkButton extends Button
{
    public function render(): View
    {
        return view('components.link-button');
    }
}
