<?php

declare(strict_types=1);

namespace App\Enums;

use InvalidArgumentException;

enum Locale: string
{
    private const URL_MAP = [
        'zh-tw' => self::zh_TW,
        'en' => self::en,
    ];

    case zh_TW = 'zh-tw';
    case en = 'en';

    public static function fromUrl(string $localeString): self
    {
        return self::URL_MAP[$localeString] ?? throw new InvalidArgumentException('Invalid locale: ' . $localeString);
    }

    public function toBcp47(): string
    {
        return match ($this) {
            self::zh_TW => 'zh-Hant-TW',
            self::en => 'en',
        };
    }

    public function toLaravelLocale(): string
    {
        return match ($this) {
            self::zh_TW => 'zh_TW',
            self::en => 'en',
        };
    }
}
