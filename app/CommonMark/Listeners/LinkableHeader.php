<?php

declare(strict_types=1);

namespace App\CommonMark\Listeners;

use League\CommonMark\Block\Element\Heading;
use League\CommonMark\Block\Element\Paragraph;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Inline\Element\HtmlInline;
use League\CommonMark\Inline\Element\Link;

final class LinkableHeader
{
    public function __invoke(DocumentParsedEvent $event)
    {
        $walker = $event->getDocument()->walker();
        $replaces = [];

        while ($current = $walker->next()) {
            $node = $current->getNode();
            $previousNode = $node->previous();
            $previousNodeChild = $previousNode?->firstChild();

            if (
                $node instanceof Heading &&
                $previousNode instanceof Paragraph &&
                $previousNodeChild instanceof HtmlInline &&
                $current->isEntering()
            ) {
                $matches = [];
                preg_match('#name="(?P<name>.+)"#', $previousNodeChild->getContent(), $matches);
                if (empty($matches['name'])) {
                    continue;
                }

                $id = $matches['name'];

                $link = new Link("#{$id}", $node->getStringContent());

                $replaces[] = [
                    'heading' => $node,
                    'id' => $id,
                    'link' => $link,
                    'remove' => $previousNode,
                ];
            }
        }

        /**
         * @var Heading $heading
         * @var string $id
         * @var Link $link
         * @var Paragraph $remove
         */
        foreach ($replaces as ['heading' => $heading, 'id' => $id, 'link' => $link, 'remove' => $remove]) {
            $remove->detach();
            $heading->replaceChildren([$link]);
            $heading->data['attributes']['id'] = $id;
        }
    }
}
