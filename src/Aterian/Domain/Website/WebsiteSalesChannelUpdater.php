<?php

declare(strict_types=1);

namespace Aterian\Domain\Website;

use Aterian\Domain\Product;
use Aterian\Domain\SalesChannelUpdater;
use Aterian\Domain\SalesChannelUpdaterException;
use Aterian\Domain\StockKeepingUnit;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface as HttpClient;

final class WebsiteSalesChannelUpdater implements SalesChannelUpdater
{
    public function __construct(private readonly HttpClient $httpClient)
    {
    }

    // todo: unit tests
    public function update(Product $product, StockKeepingUnit $sku): void
    {
        try {
            $request = [
                'headers' => ['Authorization' => 'Bearer ' . getenv('ATR_SHOP_API_SECRET')],
                'body' => http_build_query(['quantity' => $sku->quantity()]),
            ];
            // todo log $request
            $this->httpClient->sendRequest(
                new Request(
                    'GET',
                    'http://api.the-best-shop-ever.com/inventory/' . $product->id(),
                    ...$request,
                ),
            );
        } catch (\Throwable $e) {
            throw new SalesChannelUpdaterException('Error occurred when updating an inventory', 0, $e);
        }
    }
}
