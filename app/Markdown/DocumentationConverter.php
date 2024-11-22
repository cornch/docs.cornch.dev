<?php

declare(strict_types=1);

namespace App\Markdown;

use App\Markdown\Block\Element\Callout;
use App\Markdown\Block\Element\MarkdownDiv;
use App\Markdown\Block\Renderer\CalloutRenderer;
use App\Markdown\Block\Renderer\MarkdownDivRenderer;
use App\Markdown\Block\Renderer\TableRenderer;
use App\Markdown\Listeners\LinkableHeader;
use App\Markdown\Listeners\LinkFixer;
use App\Markdown\Parsers\CalloutParser;
use App\Markdown\Parsers\MarkdownDivParser;
use App\Markdown\Parsers\RubyParser;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\Attributes\AttributesExtension;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\Extension\Table\Table;
use League\CommonMark\MarkdownConverter;
use Torchlight\Commonmark\V2\TorchlightExtension;

final class DocumentationConverter extends MarkdownConverter
{
    public function __construct(?\Closure $linkFixer = null)
    {
        $environment = new Environment(['allow_unsafe_links' => false]);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);

        $environment->addExtension(new FrontMatterExtension);

        $environment->addExtension(new AttributesExtension);

        $environment->addExtension(new TorchlightExtension);

        $environment->addEventListener(DocumentParsedEvent::class, new LinkFixer($linkFixer));
        $environment->addEventListener(DocumentParsedEvent::class, new LinkableHeader);

        $environment->addBlockStartParser(CalloutParser::createBlockStartParser(), 80);
        $environment->addRenderer(Callout::class, new CalloutRenderer);

        $environment->addBlockStartParser(MarkdownDivParser::createBlockStartParser(), 50);
        $environment->addRenderer(MarkdownDiv::class, new MarkdownDivRenderer);

        $environment->addRenderer(Table::class, new TableRenderer, 10);

        $environment->addInlineParser(new RubyParser);

        parent::__construct($environment);
    }
}
