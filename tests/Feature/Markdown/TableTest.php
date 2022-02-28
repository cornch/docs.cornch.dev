<?php

it('should have a wrapper on table', function () {
    $converter = makeDocumentationConverter();

    $html = $converter->convert($markdown = <<<_MARKDOWN
| header 1 | header 2 |
| -------- | -------- |
| cell 1   | cell 2   |
_MARKDOWN
    )->getContent();

    expect(str_replace("\n", '', $html))->toBe('<div class="table__wrapper"><table><thead><tr><th>header 1</th><th>header 2</th></tr></thead><tbody><tr><td>cell 1</td><td>cell 2</td></tr></tbody></table></div>');
});
