<?php

declare(strict_types=1);

namespace App\Markdown\Listeners;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;

final class LinkFixer
{
    public function __construct(
        private ?\Closure $fixer
    ) {}

    public function __invoke(DocumentParsedEvent $event): void
    {
        if ($this->fixer === null) {
            return;
        }

        $walker = $event->getDocument()->walker();

        while ($current = $walker->next()) {
            $node = $current->getNode();
            if (! $node instanceof Link || ! $current->isEntering()) {
                continue;
            }

            $node->setUrl(($this->fixer)($node->getUrl()));
        }
    }
}
