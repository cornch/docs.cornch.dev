<?php

declare(strict_types=1);

namespace App\CommonMark\Parsers;

use App\CommonMark\Block\Element\MarkdownDiv;
use JetBrains\PhpStorm\Pure;
use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

final class MarkdownDivParser extends AbstractBlockContinueParser
{
    private const CLOSE_TAG = '</div>';
    private const CLOSE_TAG_LENGTH = 6;

    private MarkdownDiv $markdownDiv;

    #[Pure]
    public function __construct(string $class)
    {
        $this->markdownDiv = new MarkdownDiv($class);
    }

    public function getBlock(): AbstractBlock
    {
        return $this->markdownDiv;
    }

    public function isContainer(): bool
    {
        return true;
    }

    public function canContain(AbstractBlock $childBlock): bool
    {
        return true;
    }

    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        $substringForDetermine = $cursor->getSubstring($cursor->getNextNonSpacePosition(), self::CLOSE_TAG_LENGTH);
        if ($substringForDetermine === self::CLOSE_TAG) {
            $cursor->advanceBy(self::CLOSE_TAG_LENGTH);
            return BlockContinue::finished();
        }

        return BlockContinue::at($cursor);
    }

    public static function createBlockStartParser(): BlockStartParserInterface
    {
        return new class () implements BlockStartParserInterface {
            private const START_STRING = '<div';

            public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
            {
                $subStringForDetermine = $cursor->getSubstring($cursor->getNextNonSpacePosition());

                if (!str_starts_with($subStringForDetermine, self::START_STRING)) {
                    return BlockStart::none();
                }

                if (!str_contains($subStringForDetermine, 'markdown="1"')) {
                    return BlockStart::none();
                }

                $cursor->advanceToEnd();

                // extract class
                preg_match('/class="([^"]*?)"/', $subStringForDetermine, $matches);
                $class = $matches[1] ?? '';

                return BlockStart::of(new MarkdownDivParser($class))->at($cursor);
            }
        };
    }
}
