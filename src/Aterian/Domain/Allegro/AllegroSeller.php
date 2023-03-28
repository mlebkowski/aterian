<?php

declare(strict_types=1);

namespace Aterian\Domain\Allegro;

final class AllegroSeller
{
    public function __construct(private readonly string $id, private readonly string $refreshToken)
    {
    }

    public function id(): string
    {
        return $this->id;
    }

    public function refreshToken(): string
    {
        return $this->refreshToken;
    }
}
