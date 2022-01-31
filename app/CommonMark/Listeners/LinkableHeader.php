<?php

declare(strict_types=1);

namespace App\CommonMark\Listeners;

use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\Node\Block\Heading;
use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Extension\CommonMark\Node\Inline\Link;
use League\CommonMark\Node\Block\Paragraph;

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
                preg_match('#name="(?P<name>.+)"#', $previousNodeChild->getLiteral(), $matches);
                if (empty($matches['name'])) {
                    continue;
                }

                $id = $matches['name'];

                $link = new Link("#{$id}");

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
            $link->replaceChildren($heading->children());
            $heading->replaceChildren([$link]);
            $heading->data->set('attributes.id', $id);
        }
    }
}
