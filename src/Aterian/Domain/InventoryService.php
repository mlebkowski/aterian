<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Aterian\Domain\Logger\Logger;

final class InventoryService
{
    /** @var SalesChannelUpdater[] */
    private readonly array $updaters;

    public function __construct(
        private readonly Inventory $inventory,
        private readonly Logger $logger,
        SalesChannelUpdater ...$updaters,
    ) {
        $this->updaters = $updaters;
    }

    public function updateInventory(Product $product): void
    {
        $inventory = $this->inventory->getFor($product);
        foreach ($this->updaters as $updater) {
            try {
                $updater->update($product, $inventory);
            } catch (SalesChannelUpdaterException $e) {
                $this->logger->logException($e);
            }
        }
    }
}
