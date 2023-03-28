<?php

declare(strict_types=1);

namespace Aterian\Domain\Website;

use Aterian\Domain\Http\HttpClient;
use Aterian\Domain\Http\HttpClientException;
use Aterian\Domain\Product;
use Aterian\Domain\SalesChannelUpdater;
use Aterian\Domain\SalesChannelUpdaterException;
use Aterian\Domain\StockKeepingUnit;

final class WebsiteSalesChannelUpdater implements SalesChannelUpdater
{
    public function __construct(
        private readonly WebsiteToken $token,
        private readonly HttpClient $httpClient,
    ) {
    }

    public function update(Product $product, StockKeepingUnit $sku): void
    {
        try {
            $payload = ['quantity' => $sku->quantity()];
            $this->httpClient->request(
                $this->token->value,
                'http://api.the-best-shop-ever.com/inventory/' . $product->id(),
                $payload,
            );
        } catch (HttpClientException $e) {
            throw new SalesChannelUpdaterException('Error occurred when updating an inventory', 0, $e);
        }
    }
}
