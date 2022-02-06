<?php

declare(strict_types=1);

namespace App\CommonMark\Block\Renderer;

use App\CommonMark\Block\Element\MarkdownDiv;
use League\CommonMark\Node\Node;
use League\CommonMark\Renderer\ChildNodeRendererInterface;
use League\CommonMark\Renderer\NodeRendererInterface;
use League\CommonMark\Util\HtmlElement;

final class MarkdownDivRenderer implements NodeRendererInterface
{
    public function render(Node $node, ChildNodeRendererInterface $childRenderer)
    {
        MarkdownDiv::assertInstanceOf($node);

        /** @var MarkdownDiv $node */

        return new HtmlElement('div', array_filter([
            'id' => $node->id,
            'class' => $node->class
        ]), $childRenderer->renderNodes($node->children()));
    }
}
