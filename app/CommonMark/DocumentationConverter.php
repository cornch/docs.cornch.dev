<?php

declare(strict_types=1);

namespace App\CommonMark;

use App\CommonMark\Block\Element\Callout;
use App\CommonMark\Block\Renderer\CalloutRenderer;
use App\CommonMark\Listeners\LinkableHeader;
use App\CommonMark\Listeners\LinkFixer;
use App\CommonMark\Parsers\CalloutParser;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\Attributes\AttributesExtension;

final class DocumentationConverter extends CommonMarkConverter
{
    public function __construct(?\Closure $linkFixer = null)
    {
        $environment = Environment::createGFMEnvironment();

        $environment->addExtension(new AttributesExtension());

        $environment->addEventListener(DocumentParsedEvent::class, new LinkFixer($linkFixer));
        $environment->addEventListener(DocumentParsedEvent::class, new LinkableHeader());
        $environment->addBlockParser(new CalloutParser());
        $environment->addBlockRenderer(Callout::class, new CalloutRenderer());

        parent::__construct(['allow_unsafe_links' => false], $environment);
    }
}
