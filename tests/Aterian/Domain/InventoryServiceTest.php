<?php

namespace Aterian\Domain;

use Allegro\AllegroOauthSdk;
use Allegro\AllegroSellerSdk;
use Aterian\Domain\Allegro\AllegroSellerAccounts;
use Aterian\Domain\Allegro\AllegroSellerMother;
use GuzzleHttp\Client;
use PHPUnit\Framework\TestCase;

class InventoryServiceTest extends TestCase
{
    private Product $product;
    private StubInventory $inventory;
    private AllegroSellerAccounts $allegroSellers;

    public function test product is published in allegro(): void
    {
        $this->given the product is sold on allegro();
        $this->and the inventory contains quantity(1);
        $this->and there is an allegro seller();
        $this->when the inventory is updated();
        $this->then allegro seller sdk is expected to be called with quantity(1);
    }

    private function given the product is sold on allegro(): void
    {
        $this->product = ProductMother::withSalesChannel(SalesChannel::Allegro);
    }

    private function and the inventory contains quantity(int $quantity): void
    {
        $this->inventory = StubInventory::withQuantity($quantity);
    }

    private function and there is an allegro seller(): void
    {
        $this->allegroSellers = new AllegroSellerAccounts(AllegroSellerMother::some());
    }

    private function when the inventory is updated(): void
    {
        // todo:
        $sut = new InventoryService(
            inventory: $this->inventory,
            allegroSellerAccounts: $this->allegroSellers,
            allegroSellerSdk: $this->createMock(AllegroSellerSdk::class),
            allegroOauth: $this->createMock(AllegroOauthSdk::class),
            httpClient: new Client(),
            production: false,
        );

        $sut->updateInventory($this->product);
    }

    private function then allegro seller sdk is expected to be called with quantity(int $expected): void
    {
        // todo:
    }
}
