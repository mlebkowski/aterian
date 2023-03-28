<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Allegro\AllegroOauthSdk;
use Allegro\AllegroSellerSdk;
use Aterian\Domain\Allegro\AllegroSalesChannelUpdater;
use Aterian\Domain\Allegro\AllegroSellerAccounts;
use Aterian\Domain\Http\HttpClient;
use Aterian\Domain\Logger\Logger;
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
        Logger $logger,
    ): InventoryService
    {
        return new InventoryService(
            $inventory,
            $logger,
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
