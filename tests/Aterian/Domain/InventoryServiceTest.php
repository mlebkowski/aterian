<?php

namespace Aterian\Domain;

use Allegro\AllegroOauthSdk;
use Allegro\AllegroSellerSdkSpy;
use Aterian\Domain\Allegro\AllegroSellerAccounts;
use Aterian\Domain\Allegro\AllegroSellerMother;
use Aterian\Domain\Logger\LoggerSpy;
use Aterian\Domain\Website\WebsiteTokenMother;
use Aterian\Infrastructure\HttpClientSpy;
use PHPUnit\Framework\TestCase;

// phpcs:disable PSR1.Methods.CamelCapsMethodName
class InventoryServiceTest extends TestCase
{
    private Product $product;
    private Website\WebsiteToken $token;
    private StubInventory $inventory;
    private AllegroSellerAccounts $allegroSellers;
    private AllegroSellerSdkSpy $allegroSellerSdk;
    private HttpClientSpy $httpClient;

    public function test product is published in allegro(): void
    {
        $this->given the product is sold on allegro();
        $this->and the inventory contains quantity(1);
        $this->and there is an allegro seller();
        $this->when the inventory is updated();
        $this->then allegro seller sdk is expected to be called with quantity(1);
        $this->and there are no website requests();
    }

    public function test product is published on the website(): void
    {
        $this->given the product is sold on the website();
        $this->and the inventory contains quantity(1);
        $this->when the inventory is updated();
        $this->then a website request is made with quantity(1);
        $this->and there are no allegro seller sdk calls();
    }

    public function test the website is updated even if allegro fails(): void
    {
        $this->given the product is sold in both channels();
        $this->and the inventory contains quantity(1);
        $this->and there is an allegro seller();
        $this->but the allegro sdk will fail();
        $this->when the inventory is updated();
        $this->then a website request is made with quantity(1);
    }

    protected function setUp(): void
    {
        $this->allegroSellers = new AllegroSellerAccounts();
        $this->allegroSellerSdk = AllegroSellerSdkSpy::some();
        $this->httpClient = new HttpClientSpy();
        $this->token = WebsiteTokenMother::some();
    }


    private function given the product is sold on allegro(): void
    {
        $this->product = ProductMother::withAllegro();
    }

    private function given the product is sold on the website(): void
    {
        $this->product = ProductMother::withWebsite();
    }

    private function given the product is sold in both channels(): void
    {
        $this->product = ProductMother::withBothSalesChannels();
    }

    private function and the inventory contains quantity(int $quantity): void
    {
        $this->inventory = StubInventory::withQuantity($quantity);
    }

    private function and there is an allegro seller(): void
    {
        $this->allegroSellers = new AllegroSellerAccounts(AllegroSellerMother::some());
    }

    private function but the allegro sdk will fail(): void
    {
        $this->allegroSellerSdk = AllegroSellerSdkSpy::throwing();
    }

    private function when the inventory is updated(): void
    {
        $sut = InventoryServiceFactory::make(
            inventory: $this->inventory,
            allegroSellers: $this->allegroSellers,
            allegroSellerSdk: $this->allegroSellerSdk,
            allegroOauthSdk: $this->createMock(AllegroOauthSdk::class),
            token: $this->token,
            httpClient: $this->httpClient,
            logger: new LoggerSpy(),
        );

        $sut->updateInventory($this->product);
    }

    private function then allegro seller sdk is expected to be called with quantity(int $expected): void
    {
        self::assertCount(1, $this->allegroSellerSdk->calls);
        self::assertSame(
            [
                'accessToken' => '',
                'id' => $this->product->id(),
                'quantity' => $expected,
            ],
            $this->allegroSellerSdk->calls[0],
        );
    }

    private function then a website request is made with quantity(int $quantity): void
    {
        self::assertCount(1, $this->httpClient->requests);
        [$request] = $this->httpClient->requests;

        self::assertSame(
            'http://api.the-best-shop-ever.com/inventory/' . $this->product->id(),
            (string)$request->getUri(),
        );

        self::assertSame(
            sprintf('quantity=%d', $quantity),
            (string)$request->getBody(),
        );

        self::assertSame(
            sprintf('Bearer %s', $this->token->value),
            $request->getHeaderLine('Authorization')
        );
    }

    private function and there are no website requests(): void
    {
        self::assertCount(0, $this->httpClient->requests);
    }

    private function and there are no allegro seller sdk calls(): void
    {
        self::assertCount(0, $this->allegroSellerSdk->calls);
    }
}
