<?php

declare(strict_types=1);

it('parses content list', function (): void {
    $c = makeDocumentationConverter();

    $html = $c->convert(<<<'_MD'
<div class="content-list" markdown="1">
- list item
- list 2
</div>
_MD
    )->getContent();

    expect($html)->toMatchSnapshot();
});

it('parses content list with id', function (): void {
    $c = makeDocumentationConverter();

    $html = $c->convert(<<<'_MD'
<div id="test-content-list" class="content-list" markdown="1">
- list item
- list 2
</div>
_MD
    )->getContent();

    expect($html)->toMatchSnapshot();
});
