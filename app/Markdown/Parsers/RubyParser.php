<?php

declare(strict_types=1);

namespace App\Markdown\Parsers;

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
        // @TODO: temporary fix for URL encoding. This should be fixed on babelo-fisho's side.
        $rt = urldecode($rt);
        $inlineContext->getContainer()->appendChild(new HtmlInline('<ruby>' . $ruby . '<rp>(</rp><rt>' . $rt . '</rt><rp>)</rp></ruby>'));

        return true;
    }
}
