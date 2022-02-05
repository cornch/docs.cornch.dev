<?php

declare(strict_types=1);

namespace App\CommonMark\Parsers;

use App\CommonMark\Block\Element\Callout;
use JetBrains\PhpStorm\Pure;
use League\CommonMark\Node\Block\AbstractBlock;
use League\CommonMark\Parser\Block\AbstractBlockContinueParser;
use League\CommonMark\Parser\Block\BlockContinue;
use League\CommonMark\Parser\Block\BlockContinueParserInterface;
use League\CommonMark\Parser\Block\BlockStart;
use League\CommonMark\Parser\Block\BlockStartParserInterface;
use League\CommonMark\Parser\Cursor;
use League\CommonMark\Parser\MarkdownParserStateInterface;

final class CalloutParser extends AbstractBlockContinueParser
{
    private Callout $callout;

    #[Pure]
    public function __construct(string $type)
    {
        $this->callout = new Callout($type);
    }

    public function getBlock(): AbstractBlock
    {
        return $this->callout;
    }

    public function isContainer(): bool
    {
        return true;
    }

    public function canContain(AbstractBlock $childBlock): bool
    {
        return true;
    }

    public function canHaveLazyContinuationLines(): bool
    {
        return false;
    }

    #[Pure]
    public function tryContinue(Cursor $cursor, BlockContinueParserInterface $activeBlockParser): ?BlockContinue
    {
        return BlockContinue::none();
    }

    public static function createBlockStartParser(): BlockStartParserInterface
    {
        return new class () implements BlockStartParserInterface {
            private const START_STRING = '> {';

            public function tryStart(Cursor $cursor, MarkdownParserStateInterface $parserState): ?BlockStart
            {
                if ($cursor->isIndented()) {
                    return BlockStart::none();
                }

                if (!str_starts_with($cursor->getSubstring($cursor->getPosition()), self::START_STRING)) {
                    return BlockStart::none();
                }

                $cursor->advanceBy(strlen(self::START_STRING));

                // extract type
                $sub = $cursor->getSubstring($cursor->getPosition());
                $typeClosingPosition = mb_strpos($sub, '}');
                $cursor->advanceBy($typeClosingPosition + 2);
                $cursor->advanceBySpaceOrTab();

                $type = mb_substr($sub, 0, $typeClosingPosition);

                return BlockStart::of(new CalloutParser($type))->at($cursor);
            }
        };
    }
}
