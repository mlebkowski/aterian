<?php

declare(strict_types=1);

namespace Aterian\Domain;

final class StockKeepingUnit
{
    public function __construct(private readonly int $quantity)
    {
    }

    public function quantity(): int
    {
        return $this->quantity;
    }
}
