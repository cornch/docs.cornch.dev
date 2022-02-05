<?php

declare(strict_types=1);

namespace App\CommonMark\Listeners;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Block\ListItem;
use Ramsey\Uuid\Uuid;

final class NavigationLinkEvent
{
    public function __invoke(DocumentParsedEvent $event): void
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

                /** @var ListItem $parent */
                $parent = $node->parent();
                $parent->data->set('attributes.x-bind:class', /** @lang JavaScript */ "{ 'sub--on': opening === '{$uuid}' }");
                $parent->data->set('attributes.data-uuid', $uuid);

                // open by default for noscript users
                $parent->data->set('attributes.class', 'sub--on');

                $node->data->set('attributes.x-on:click.self', /** @lang JavaScript */ "opening = '{$uuid}'");
            }
        }
    }
}
