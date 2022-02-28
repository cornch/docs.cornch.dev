<?php

declare(strict_types=1);

namespace App\CommonMark;

use App\CommonMark\Block\Element\Callout;
use App\CommonMark\Block\Element\MarkdownDiv;
use App\CommonMark\Block\Renderer\CalloutRenderer;
use App\CommonMark\Block\Renderer\MarkdownDivRenderer;
use App\CommonMark\Block\Renderer\TableRenderer;
use App\CommonMark\Listeners\LinkableHeader;
use App\CommonMark\Listeners\LinkFixer;
use App\CommonMark\Parsers\CalloutParser;
use App\CommonMark\Parsers\MarkdownDivParser;
use App\CommonMark\Parsers\RubyParser;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\MarkdownConverter;
use Torchlight\Commonmark\V2\TorchlightExtension;

final class DocumentationConverter extends MarkdownConverter
{
    public function __construct(?\Closure $linkFixer = null)
    {
        $environment = new Environment(['allow_unsafe_links' => false]);
        $environment->addExtension(new CommonMarkCoreExtension());
        $environment->addExtension(new GithubFlavoredMarkdownExtension());

        $environment->addExtension(new AttributesExtension());

        $environment->addExtension(new TorchlightExtension());

        $environment->addEventListener(DocumentParsedEvent::class, new LinkFixer($linkFixer));
        $environment->addEventListener(DocumentParsedEvent::class, new LinkableHeader());

        $environment->addBlockStartParser(CalloutParser::createBlockStartParser(), 80);
        $environment->addRenderer(Callout::class, new CalloutRenderer());

        $environment->addBlockStartParser(MarkdownDivParser::createBlockStartParser(), 50);
        $environment->addRenderer(MarkdownDiv::class, new MarkdownDivRenderer());

        $environment->addRenderer(Table::class, new TableRenderer(), 10);

        $environment->addInlineParser(new RubyParser());

        parent::__construct($environment);
    }
}
