<?php

declare(strict_types=1);

namespace Aterian\Domain;

interface Inventory
{
    public function getFor(Product $product): StockKeepingUnit;
}
