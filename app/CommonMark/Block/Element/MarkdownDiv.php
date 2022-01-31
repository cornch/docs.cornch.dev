<?php

declare(strict_types=1);

namespace App\CommonMark\Block\Element;

use League\CommonMark\Node\Block\AbstractBlock;

final class MarkdownDiv extends AbstractBlock
{
    public function __construct(
        private string $class = '',
    ) {
        parent::__construct();
    }

    public function getClass(): string
    {
        return $this->class;
    }
}
