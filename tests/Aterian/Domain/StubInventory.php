<?php

declare(strict_types=1);

namespace Aterian\Domain;

final class StubInventory implements Inventory
{
    public static function withQuantity(int $quantity): self
    {
        return new self($quantity);
    }

    private function __construct(private readonly int $quantity)
    {
    }


    public function getFor(Product $product): StockKeepingUnit
    {
        return new StockKeepingUnit(quantity: $this->quantity);
    }
}
