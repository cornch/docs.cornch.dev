<?php

declare(strict_types=1);

it('parses callout', function (): void {
    $converter = makeDocumentationConverter();

    $html = $converter
        ->convert('> {tip} 123')
        ->getContent();

    expect($html)->toMatchSnapshot();

    $html = $converter
        ->convert('> **Note** 123')
        ->getContent();

    expect($html)->toMatchSnapshot();
});
