<?php

namespace App\CommonMark\Block\Renderer;

use League\CommonMark\Extension\Table\Table;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;
use League\CommonMark\Xml\XmlNodeRendererInterface;

final class TableRenderer implements NodeRendererInterface, XmlNodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer): \Stringable
    {
        Table::assertInstanceOf($node);

        $attrs = $node->data->get('attributes');

        $separator = $childRenderer->getInnerSeparator();

        $children = $childRenderer->renderNodes($node->children());

        return new HtmlElement(
            'div',
            ['class' => 'table__wrapper'],
            new HtmlElement('table', $attrs, $separator . \trim($children) . $separator),
        );
    }

    public function getXmlTagName(Node $node): string
    {
        return 'table';
    }

    /**
     * {@inheritDoc}
     */
    public function getXmlAttributes(Node $node): array
    {
        return [];
    }
}
