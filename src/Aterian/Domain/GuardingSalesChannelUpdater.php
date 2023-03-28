<?php

declare(strict_types=1);

namespace Aterian\Domain;

final class GuardingSalesChannelUpdater implements SalesChannelUpdater
{

    public function __construct(
        private readonly SalesChannel $channel,
        private readonly SalesChannelUpdater $inner,
    ) {
    }

    public function update(Product $product, StockKeepingUnit $sku): void
    {
        if (false === $product->isSoldOn($this->channel)) {
            return;
        }

        $this->inner->update($product, $sku);
    }
}
