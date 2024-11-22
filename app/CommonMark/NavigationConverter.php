<?php

declare(strict_types=1);

namespace App\CommonMark;

use App\CommonMark\Listeners\LinkFixer;
use App\CommonMark\Listeners\NavigationLinkEvent;
use League\CommonMark\Environment\Environment;
use League\CommonMark\Event\DocumentParsedEvent;
use League\CommonMark\Extension\CommonMark\CommonMarkCoreExtension;
use League\CommonMark\Extension\FrontMatter\FrontMatterExtension;
use League\CommonMark\Extension\GithubFlavoredMarkdownExtension;
use League\CommonMark\MarkdownConverter;

final class NavigationConverter extends MarkdownConverter
{
    public function __construct(?\Closure $linkFixer = null)
    {
        $environment = new Environment(['allow_unsafe_links' => true]);
        $environment->addExtension(new CommonMarkCoreExtension);
        $environment->addExtension(new GithubFlavoredMarkdownExtension);
        $environment->addExtension(new FrontMatterExtension);

        $environment->addEventListener(DocumentParsedEvent::class, new NavigationLinkEvent);
        $environment->addEventListener(DocumentParsedEvent::class, new LinkFixer($linkFixer));

        parent::__construct($environment);
    }
}
