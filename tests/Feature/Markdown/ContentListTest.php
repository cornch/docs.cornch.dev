<?php

declare(strict_types=1);

it('parses content list', function () {
    $c = makeDocumentationConverter();

    $html = $c->convert(<<<_MD
<div class="content-list" markdown="1">
- list item
- list 2
</div>
_MD
)->getContent();

    $expected = '#
        <div\s+class="content-list">[\w\W]*?
            <ul>[\w\W]*?
                <li>list\sitem</li>[\w\W]*?
                <li>list\s2</li>[\w\W]*?
            </ul>[\w\W]*?
        </div>
    #ix';

    expect($html)->toMatch($expected);
});

it('parses content list with id', function () {
    $c = makeDocumentationConverter();

    $html = $c->convert(<<<_MD
<div id="test-content-list" class="content-list" markdown="1">
- list item
- list 2
</div>
_MD
    )->getContent();

    $expected = '#
        <div\s+id="test-content-list"\s+class="content-list">[\w\W]*?
            <ul>[\w\W]*?
                <li>list\sitem</li>[\w\W]*?
                <li>list\s2</li>[\w\W]*?
            </ul>[\w\W]*?
        </div>
    #ix';

    expect($html)->toMatch($expected);
});
