<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Allegro\AllegroSellerSdk\AllegroInventory;
use Aterian\Domain\Allegro\AllegroSalesChannelUpdater;
use Aterian\Domain\Website\WebsiteSalesChannelUpdater;

final class InventoryService
{
    public function __construct(
        private readonly Inventory $inventory,
        private readonly AllegroSalesChannelUpdater $allegro,
        private readonly WebsiteSalesChannelUpdater $website,
    ) {
    }

    public function updateInventory(Product $product): void
    {
        $inventory = $this->inventory->getFor($product);
        if ($product->isSoldOn(SalesChannel::Allegro)) {
            $this->allegro->update($product, $inventory);
        }
        if ($product->isSoldOn(SalesChannel::Website)) {
            $this->website->update($product, $inventory);
        }
    }
}
