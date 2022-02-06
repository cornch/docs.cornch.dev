<?php

declare(strict_types=1);

namespace App\Utils;

use JetBrains\PhpStorm\Pure;

final class Pipe
{
    public function __construct(
        public readonly mixed $endpipe
    ) {
    }

    #[Pure]
    public static function from(mixed $data): Pipe
    {
        return new Pipe($data);
    }

    public function __invoke(callable $callback): Pipe
    {
        return new Pipe($callback($this->endpipe));
    }
}
