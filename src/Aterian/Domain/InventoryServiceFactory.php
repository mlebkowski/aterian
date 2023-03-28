<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Allegro\AllegroOauthSdk;
use Allegro\AllegroSellerSdk;
use Aterian\Domain\Allegro\AllegroSalesChannelUpdater;
use Aterian\Domain\Allegro\AllegroSellerAccounts;
use Aterian\Domain\Website\WebsiteSalesChannelUpdaterFactory;
use Psr\Http\Client\ClientInterface;

final class InventoryServiceFactory
{
    public static function make(
        Inventory $inventory,
        AllegroSellerAccounts $allegroSellers,
        AllegroSellerSdk $allegroSellerSdk,
        AllegroOauthSdk $allegroOauthSdk,
        ClientInterface $httpClient,
        bool $production,
    ): InventoryService
    {
        return new InventoryService(
            $inventory,
            new AllegroSalesChannelUpdater(
                allegroSellerAccounts: $allegroSellers,
                allegroSellerSdk: $allegroSellerSdk,
                allegroOauth: $allegroOauthSdk,
            ),
            WebsiteSalesChannelUpdaterFactory::make(
                httpClient: $httpClient,
                production: $production,
            ),
        );
    }
}
