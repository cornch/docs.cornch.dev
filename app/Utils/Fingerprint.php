<?php

declare(strict_types=1);

namespace App\Utils;

use Illuminate\Http\Request;
use Illuminate\Support\Arr;

final class Fingerprint
{
    public function __construct(
        private array $data
    ) {
    }

    public static function fromRequest(Request $request): static
    {
        return new static([
            $request->ip(),
            $request->userAgent(),
        ]);
    }

    public function push($value): static
    {
        $this->data[] = $value;

        return $this;
    }

    public function __toString(): string
    {
        return sha1(implode('|', Arr::sort($this->data)));
    }
}
