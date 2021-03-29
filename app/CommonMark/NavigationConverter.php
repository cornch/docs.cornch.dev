<?php

declare(strict_types=1);

namespace App\CommonMark;

use App\CommonMark\Listeners\LinkFixer;
use App\CommonMark\Listeners\NavigationLinkEvent;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Event\DocumentParsedEvent;

final class NavigationConverter extends CommonMarkConverter
{
    public function __construct(?\Closure $linkFixer = null)
    {
        $environment = Environment::createGFMEnvironment();
        $environment->addEventListener(DocumentParsedEvent::class, new NavigationLinkEvent());
        $environment->addEventListener(DocumentParsedEvent::class, new LinkFixer($linkFixer));

        parent::__construct([], $environment);
    }

}
