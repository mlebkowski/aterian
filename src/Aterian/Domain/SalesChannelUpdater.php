<?php

declare(strict_types=1);

namespace Aterian\Domain;

interface SalesChannelUpdater
{
    /**
     * @throws SalesChannelUpdaterException
     */
    public function update(Product $product, StockKeepingUnit $sku): void;
}
