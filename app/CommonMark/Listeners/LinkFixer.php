<?php

declare(strict_types=1);

namespace App\CommonMark\Listeners;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Inline\Element\Link;

final class LinkFixer
{
    public function __construct(
        private ?\Closure $fixer
    ) {
    }

    public function __invoke(DocumentParsedEvent $event)
    {
        if ($this->fixer === null) {
            return;
        }

        $walker = $event->getDocument()->walker();

        while ($current = $walker->next()) {
            $node = $current->getNode();
            if (!$node instanceof Link || !$current->isEntering()) {
                continue;
            }

            $node->setUrl(($this->fixer)($node->getUrl()));
        }
    }
}
