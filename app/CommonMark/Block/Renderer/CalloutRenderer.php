<?php

declare(strict_types=1);

namespace App\CommonMark\Block\Renderer;

use App\CommonMark\Block\Element\Callout;
use League\CommonMark\Block\Element\AbstractBlock;
use League\CommonMark\Block\Element\Paragraph;
use League\CommonMark\Block\Renderer\BlockRendererInterface;
use League\CommonMark\ElementRendererInterface;
use League\CommonMark\HtmlElement;

final class CalloutRenderer implements BlockRendererInterface
{
    public function render(AbstractBlock $block, ElementRendererInterface $htmlRenderer, bool $inTightList = false)
    {
        if (!($block instanceof Callout)) {
            throw new \InvalidArgumentException('Incompatible block type: ' . \get_class($block));
        }

        $baseImageClass = 'w-20 h-20 mb-6 lg:mb-0 flex items-center justify-center flex-shrink-0';

        $image = match ($block->type)  {
            'note' => new HtmlElement(
                'svg',
                ['class' => 'opacity-75', 'width' => '6', 'height' => '35', 'viewBox' => '0 0 6 35', 'xmlns' => 'http://www.w3.org/2000/svg'],
                '<title>exclamation</title><path d="M0 29h6v6H0v-6zM0 0h6v24H0V0z" fill="#FFF" fill-rule="nonzero"/>'
            ),
            'tip' => new HtmlElement(
                'svg',
                ['class' => 'opacity-75', 'width' => '28', 'height' => '40', 'viewBox' => '0 0 28 40', 'xmlns' => 'http://www.w3.org/2000/svg'],
                '<title>lightbulb</title><path d="M12 28h4v-8h-4v8zM8 40h12v-8H8v8zm13.98-14.52c-1.001.705-1.661 1.545-1.98 2.52H8c-.416-.959-1.076-1.799-1.98-2.52A13.99 13.99 0 0 1 0 14C0 6.272 6.272 0 14 0s14 6.272 14 14a13.99 13.99 0 0 1-6.02 11.48z" fill="#FFF" fill-rule="nonzero"/>'
            ),
            'video', 'laracasts' => new HtmlElement(
                'svg',
                ['class' => 'opacity-75', 'width' => '49', 'height' => '40', 'viewBox' => '0 0 49 40', 'xmlns' => 'http://www.w3.org/2000/svg'],
                '<title>laracast</title><path d="M14.21 15.79h14.737a1.579 1.579 0 1 1 0 3.157H14.211a1.579 1.579 0 0 1 0-3.158zm-7.368 0h2.105a1.579 1.579 0 1 1 0 3.157H6.842a1.579 1.579 0 1 1 0-3.158zm2.105 5.263h14.737a1.579 1.579 0 1 1 0 3.158H8.947a1.579 1.579 0 0 1 0-3.158zm-7.368 0h2.105a1.579 1.579 0 1 1 0 3.158H1.58a1.579 1.579 0 1 1 0-3.158zm11.053 6.09h4.21v5.714L42.105 20 16.842 7.143v5.714h-4.21V0l34.521 17.913a2.35 2.35 0 0 1 0 4.174L12.632 40V27.143z" fill="#FFF" fill-rule="nonzero"/>'
            ),
        };

        $imageWrapper = match ($block->type) {
            'note' => new HtmlElement('div', ['class' => $baseImageClass . ' bg-red-600'], $image),
            'tip' => new HtmlElement('div', ['class' => $baseImageClass . ' bg-purple-600'], $image),
            'video', 'laracasts' => new HtmlElement('div', ['class' => $baseImageClass . ' bg-blue-600'], $image),
        };

        foreach ($block->children() as $child) {
            if ($child instanceof Paragraph) {
                $child->data['attributes'] = $child->data['attributes'] ?? [];
                $child->data['attributes']['class'] = $child->data['attributes']['class'] ?? '';
                $child->data['attributes']['class'] .= ' !mb-0 lg:!ml-6';
            }
        }

        return new HtmlElement('div', [
            'class' => 'callout mb-10 max-w-2xl mx-auto px-4 py-8 shadow-lg lg:flex lg:items-center',
        ], [$imageWrapper, $htmlRenderer->renderBlocks($block->children())]);
    }
}
