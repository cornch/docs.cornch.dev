<?php

declare(strict_types=1);

namespace App\CommonMark\Listeners;

use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Inline\Element\Link;
use Ramsey\Uuid\Uuid;

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
                $uuid = base64_encode(Uuid::uuid4()->getBytes());

                /** @var \League\CommonMark\Block\Element\ListItem $parent */
                $parent = $node->parent();
                $parent->data['attributes']['x-bind:class'] = /** @lang JavaScript */ "{ 'sub--on': opening === '{$uuid}' }";
                $parent->data['attributes']['data-uuid'] = $uuid;

                $node->data['attributes']['x-on:click.self'] = /** @lang JavaScript */ "opening = '{$uuid}'";
            }
        }
    }
}
