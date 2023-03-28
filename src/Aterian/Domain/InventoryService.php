<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Aterian\Domain\Allegro\AllegroSalesChannelUpdater;

final class InventoryService
{
    /** @var SalesChannelUpdater[] */
    private readonly array $updaters;

    public function __construct(
        private readonly Inventory $inventory,
        SalesChannelUpdater ...$updaters,
    ) {
        $this->updaters = $updaters;
    }

    public function updateInventory(Product $product): void
    {
        $inventory = $this->inventory->getFor($product);
        foreach ($this->updaters as $updater) {
            $updater->update($product, $inventory);
        }
    }
}
