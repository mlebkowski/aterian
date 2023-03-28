<?php

declare(strict_types=1);

namespace Aterian\Domain\Website;

use Allegro\AllegroOauthSdk;
use Allegro\AllegroSellerSdk;
use Aterian\Domain\Allegro\AllegroSellerAccounts;
use Aterian\Domain\Inventory;
use Aterian\Domain\Product;
use Aterian\Domain\SalesChannelUpdater;
use Aterian\Domain\StockKeepingUnit;
use Aterian\Infrastructure\DevLogger;
use Aterian\Infrastructure\Logger;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface as HttpClient;
use Psr\Log\LoggerInterface;

final class WebsiteSalesChannelUpdater implements SalesChannelUpdater
{
    private readonly LoggerInterface $logger;

    public function __construct(
        private readonly HttpClient $httpClient,
        bool $production
    ) {
        $this->logger = $production ? Logger::instance() : new DevLogger();
    }

    // todo: unit tests
    public function update(Product $product, StockKeepingUnit $sku): void
    {
        try {
            $request = [
                'headers' => ['Authorization' => 'Bearer ' . getenv('ATR_SHOP_API_SECRET')],
                'body' => http_build_query(['quantity' => $sku->quantity()]),
            ];
            $this->logger->debug('Request', $request);
            $this->httpClient->sendRequest(
                new Request(
                    'GET',
                    'http://api.the-best-shop-ever.com/inventory/' . $product->id(),
                    ...$request,
                ),
            );
        } catch (\Throwable $e) {
            $this->logger->error('Error occurred when updating an inventory');
            throw $e;
        }
    }
}
