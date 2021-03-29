<?php

declare(strict_types=1);

namespace App\CommonMark\Listeners;

use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Event\DocumentParsedEvent;

final class NavigationLinkEvent
{
    public function __invoke(DocumentParsedEvent $event)
    {
        $walker = $event->getDocument()->walker();
        while ($current = $walker->next()) {
            $node = $current->getNode();

            if (
                $node instanceof Heading &&
                $current->isEntering() &&
                $node->getLevel() === 2
            ) {
                $node->data['attributes']['x-on:click.self'] = '$event.target.parentNode.classList.toggle(\'sub--on\')';
            }
        }
    }
}
