<?php

declare(strict_types=1);

namespace Aterian\Domain\Allegro;

use Allegro\AllegroOauthSdk;
use Allegro\AllegroSellerSdk;
use Allegro\AllegroSellerSdk\AllegroInventory;
use Aterian\Domain\Product;
use Aterian\Domain\SalesChannel;
use Aterian\Domain\SalesChannelUpdater;
use Aterian\Domain\SalesChannelUpdaterException;
use Aterian\Domain\StockKeepingUnit;
use Throwable;

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
        if (false === $product->isSoldOn(SalesChannel::Allegro)) {
            return;
        }

        foreach ($this->allegroSellerAccounts as $sellerAccount) {
            $accessToken = $this->allegroOauth->getAccessToken(
                $sellerAccount->id(),
                $sellerAccount->refreshToken(),
            );
            try {
                $this->allegroSellerSdk->setInventory(
                    $accessToken,
                    new AllegroInventory(
                        $product->id(),
                        $sku->quantity(),
                    )
                );
            } catch (Throwable $e) {
                throw SalesChannelUpdaterException::fromOther($e);
            }
        }
    }
}
