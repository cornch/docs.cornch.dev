<?php

declare(strict_types=1);

namespace App\CommonMark\Parsers;


use App\CommonMark\Block\Element\Callout;
use League\CommonMark\Block\Element\BlockQuote;
use League\CommonMark\Block\Parser\BlockParserInterface;
use League\CommonMark\ContextInterface;
use League\CommonMark\Cursor;

final class CalloutParser implements BlockParserInterface
{

    public function parse(ContextInterface $context, Cursor $cursor): bool
    {
        if ($cursor->isIndented()) {
            return false;
        }

        if (!$context->getContainer() instanceof BlockQuote) {
            return false;
        }

        if ($cursor->getCharacter() !== '{') {
            return false;
        }

        $substr = $cursor->getSubstring($cursor->getPosition() + 1);
        $pos = strpos($substr, '}');
        $cursor->advanceBy($pos + 2);
        $cursor->advanceToNextNonSpaceOrTab();

        $type = mb_substr($substr, 0, $pos);

        $context->addBlock(new Callout($type));

        return true;
    }
}
