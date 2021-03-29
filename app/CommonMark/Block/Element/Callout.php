<?php

declare(strict_types=1);

namespace App\CommonMark\Block\Element;

use League\CommonMark\Block\Element\BlockQuote;

final class Callout extends BlockQuote
{
    public function __construct(
        public string $type
    ) {
    }
}
