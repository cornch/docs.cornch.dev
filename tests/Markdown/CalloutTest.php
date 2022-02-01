<?php

declare(strict_types=1);

it('parses callout', function () {
    $converter = makeDocumentationConverter();

    $html = $converter
        ->convert('> {tip} 123')
        ->getContent();

    expect($html)
        ->toMatch('#
            <div\s+class="callout">[\w\W]*?
                <div\s+class="callout__img\s+bg-purple-600">[\w\W]*?
                    <svg[^>]+?>.+?</svg>[\w\W]*?
                </div>[\w\W]*?
                <p\s+?class="!mb-0\slg:!ml-6">[\w\W]*?
                    123[\w\W]*?
                </p>[\w\W]*?
            </div>
        #ix');
});