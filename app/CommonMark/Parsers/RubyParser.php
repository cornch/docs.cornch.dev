<?php

declare(strict_types=1);

namespace App\CommonMark\Parsers;

use League\CommonMark\Extension\CommonMark\Node\Inline\HtmlInline;
use League\CommonMark\Parser\Inline\InlineParserInterface;
use League\CommonMark\Parser\Inline\InlineParserMatch;
use League\CommonMark\Parser\InlineParserContext;

final class RubyParser implements InlineParserInterface
{
    public function getMatchDefinition(): InlineParserMatch
    {
        return InlineParserMatch::regex('\^\[([^\]]+?)]\(([^\)]+?)\)');
    }

    public function parse(InlineParserContext $inlineContext): bool
    {
        $cursor = $inlineContext->getCursor();

        $cursor->advanceBy($inlineContext->getFullMatchLength());
        [$ruby, $rt] = $inlineContext->getSubMatches();
        $inlineContext->getContainer()->appendChild(new HtmlInline('<ruby>' . $ruby . '<rp>(</rp><rt>' . $rt . '</rt><rp>)</rp></ruby>'));

        return true;
    }
}
