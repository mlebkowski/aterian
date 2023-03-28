<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Allegro\AllegroOauthSdk;
use Allegro\AllegroSellerSdk;
use Aterian\Domain\Allegro\AllegroSalesChannelUpdater;
use Aterian\Domain\Allegro\AllegroSellerAccounts;
use Aterian\Domain\Http\HttpClient;
use Aterian\Domain\Website\WebsiteSalesChannelUpdaterFactory;
use Aterian\Domain\Website\WebsiteToken;

final class InventoryServiceFactory
{
    public static function make(
        Inventory $inventory,
        AllegroSellerAccounts $allegroSellers,
        AllegroSellerSdk $allegroSellerSdk,
        AllegroOauthSdk $allegroOauthSdk,
        WebsiteToken $token,
        HttpClient $httpClient,
        bool $production,
    ): InventoryService
    {
        return new InventoryService(
            $inventory,
            $production,
            new AllegroSalesChannelUpdater(
                allegroSellerAccounts: $allegroSellers,
                allegroSellerSdk: $allegroSellerSdk,
                allegroOauth: $allegroOauthSdk,
            ),
            WebsiteSalesChannelUpdaterFactory::make(
                token: $token,
                httpClient: $httpClient,
            ),
        );
    }
}
