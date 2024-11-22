<?php

declare(strict_types=1);

namespace App\Markdown\Block\Element;

use League\CommonMark\Node\Block\AbstractBlock;

final class Callout extends AbstractBlock
{
    public function __construct(
        public string $type
    ) {
        parent::__construct();
    }
}
