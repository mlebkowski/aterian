<?php

declare(strict_types=1);

namespace Aterian\Domain;

final class Product
{
    public function __construct(private readonly string $id)
    {
    }

    public function isSoldOn(SalesChannel $channel): bool
    {
        return false;
    }

    public function id(): string
    {
        return $this->id;
    }
}
