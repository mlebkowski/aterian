<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Allegro\AllegroSellerSdk;
use Allegro\AllegroSellerSdk\AllegroInventory;
use Allegro\AllegroOauthSdk;
use Aterian\Domain\Allegro\AllegroSellerAccounts;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientInterface as HttpClient;
use Psr\Log\LoggerInterface;
use Aterian\Infrastructure\Logger;
use Aterian\Infrastructure\DevLogger;

final class InventoryService
{
    private readonly LoggerInterface $logger;

    public function __construct(
        private readonly Inventory $inventory,
        private readonly AllegroSellerAccounts $allegroSellerAccounts,
        private readonly AllegroSellerSdk $allegroSellerSdk,
        private readonly AllegroOauthSdk $allegroOauth,
        private readonly HttpClient $httpClient,
        bool $production
    ) {
        $this->logger = $production ? Logger::instance() : new DevLogger();
    }

    public function updateInventory(Product $product): void
    {
        $inventory = $this->inventory->getFor($product);
        if ($product->isSoldOn(SalesChannel::Allegro)) {
            foreach ($this->allegroSellerAccounts as $sellerAccount) {
                $accessToken = $this->allegroOauth->getAccessToken(
                    $sellerAccount->id(),
                    $sellerAccount->refreshToken()
                );
                $this->allegroSellerSdk->setInventory(
                    $accessToken,
                    new AllegroInventory(
                        $product->id(),
                        $inventory->quantity()
                    )
                );
            }
        }
        if ($product->isSoldOn(SalesChannel::Website)) {
            try {
                $request = [
                    'headers' => ['Authorization' => 'Bearer ' . getenv('ATR_SHOP_API_SECRET')],
                    'body' => http_build_query(['quantity' => $inventory->quantity()]),
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
}
