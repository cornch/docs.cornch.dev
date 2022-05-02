<?php

it('should have a wrapper on table', function () {
    $converter = makeDocumentationConverter();

    $html = $converter->convert($markdown = <<<_MARKDOWN
| header 1 | header 2 |
| -------- | -------- |
| cell 1   | cell 2   |
_MARKDOWN
    )->getContent();

    expect($html)->toMatchSnapshot();
});
