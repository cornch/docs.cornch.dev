<?php

declare(strict_types=1);

namespace App\Documentation\Models;

use DateTimeInterface;

final class Version
{
    public function __construct(
        public readonly string $key,
        public readonly string $name,
        public readonly ?DateTimeInterface $bugFixSupportEndsAt,
        public readonly ?DateTimeInterface $securitySupportEndsAt,
        public readonly bool $preRelease,
    ) {
    }

    public function receivesBugFixes(): bool
    {
        return $this->bugFixSupportEndsAt === null || $this->bugFixSupportEndsAt->getTimestamp() > time();
    }

    public function receivesSecurityFixes(): bool
    {
        return $this->securitySupportEndsAt === null || $this->securitySupportEndsAt->getTimestamp() > time();
    }

    public function deprecated(): bool
    {
        return !$this->receivesBugFixes() || !$this->receivesSecurityFixes();
    }
}
