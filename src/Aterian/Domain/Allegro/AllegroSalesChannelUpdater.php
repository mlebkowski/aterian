<?php

declare(strict_types=1);

namespace Aterian\Domain\Allegro;

use Allegro\AllegroOauthSdk;
use Allegro\AllegroSellerSdk;
use Allegro\AllegroSellerSdk\AllegroInventory;
use Aterian\Domain\Product;
use Aterian\Domain\SalesChannelUpdater;
use Aterian\Domain\StockKeepingUnit;

final class AllegroSalesChannelUpdater implements SalesChannelUpdater
{
    public function __construct(
        private readonly AllegroSellerAccounts $allegroSellerAccounts,
        private readonly AllegroSellerSdk $allegroSellerSdk,
        private readonly AllegroOauthSdk $allegroOauth,
    ) {
    }

    // todo: unit tests
    public function update(Product $product, StockKeepingUnit $sku): void
    {
        foreach ($this->allegroSellerAccounts as $sellerAccount) {
            $accessToken = $this->allegroOauth->getAccessToken(
                $sellerAccount->id(),
                $sellerAccount->refreshToken(),
            );
            $this->allegroSellerSdk->setInventory(
                $accessToken,
                new AllegroInventory(
                    $product->id(),
                    $sku->quantity(),
                )
            );
        }
    }
}
