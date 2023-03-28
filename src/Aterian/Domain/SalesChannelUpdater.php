<?php

declare(strict_types=1);

namespace Aterian\Domain;

interface SalesChannelUpdater
{
    public function update(Product $product, StockKeepingUnit $sku): void;
}
