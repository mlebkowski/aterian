<?php

declare(strict_types=1);

namespace Aterian\Domain\Website;

final class WebsiteToken
{
    public static function of(string $token): self
    {
        return new self($token);
    }

    private function __construct(public readonly string $value)
    {
    }
}
