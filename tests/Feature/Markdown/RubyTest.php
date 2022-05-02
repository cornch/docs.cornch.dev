<?php

declare(strict_types=1);

it('parses ruby', function () {
    $parser = makeDocumentationConverter();
    $actual = $parser
        ->convert('Laravel 致力於提供優質的開發體驗，並提供多種強大的功能，包含^[相依性插入](Dependency Injection)、描述性的資料庫抽象層、佇列與排程任務、^[單元測試](Unit Testing)與^[整合測試](Integration Testing)⋯⋯等功能。')
        ->getContent();

    $expect = '<p>Laravel 致力於提供優質的開發體驗，並提供多種強大的功能，包含<ruby>相依性插入<rp>(</rp><rt>Dependency Injection</rt><rp>)</rp></ruby>、描述性的資料庫抽象層、佇列與排程任務、<ruby>單元測試<rp>(</rp><rt>Unit Testing</rt><rp>)</rp></ruby>與<ruby>整合測試<rp>(</rp><rt>Integration Testing</rt><rp>)</rp></ruby>⋯⋯等功能。</p>';

    expect(trim($actual))->toMatchSnapshot();
});
