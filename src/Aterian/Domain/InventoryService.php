<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Aterian\Infrastructure\DevLogger;
use Aterian\Infrastructure\Logger;
use Psr\Log\LoggerInterface;

final class InventoryService
{
    /** @var SalesChannelUpdater[] */
    private readonly array $updaters;

    private readonly LoggerInterface $logger;

    public function __construct(
        private readonly Inventory $inventory,
        bool $production,
        SalesChannelUpdater ...$updaters,
    ) {
        $this->updaters = $updaters;
        $this->logger = $production ? Logger::instance() : new DevLogger();
    }

    public function updateInventory(Product $product): void
    {
        $inventory = $this->inventory->getFor($product);
        foreach ($this->updaters as $updater) {
            try {
                $updater->update($product, $inventory);
            } catch (SalesChannelUpdaterException $e) {
                $this->logger->error($e->getMessage());
            }
        }
    }
}
