<?php

declare(strict_types=1);

it('parses callout', function () {
    $converter = makeDocumentationConverter();

    $html = $converter
        ->convert('> {tip} 123')
        ->getContent();

    expect($html)->toMatchSnapshot();
});
