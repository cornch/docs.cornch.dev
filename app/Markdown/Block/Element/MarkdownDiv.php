<?php

declare(strict_types=1);

namespace App\Markdown\Block\Element;

use League\CommonMark\Node\Block\AbstractBlock;

final class MarkdownDiv extends AbstractBlock
{
    public function __construct(
        public readonly string $id = '',
        public readonly string $class = '',
    ) {
        parent::__construct();
    }
}
