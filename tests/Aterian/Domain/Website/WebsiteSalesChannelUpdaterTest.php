<?php

namespace Aterian\Domain\Website;

use Aterian\Domain\ProductMother;
use Aterian\Domain\StockKeepingUnitMother;
use Aterian\Infrastructure\HttpClientSpy;
use PHPUnit\Framework\TestCase;

class WebsiteSalesChannelUpdaterTest extends TestCase
{
    public function test(): void
    {
        // arrange:
        $httpClient = new HttpClientSpy();
        $token = WebsiteTokenMother::some();
        $product = ProductMother::some();
        $sku = StockKeepingUnitMother::some();
        $sut = new WebsiteSalesChannelUpdater($token, $httpClient);

        // act:
        $sut->update($product, $sku);

        // assert:
        self::assertCount(1, $httpClient->requests);
        $request = $httpClient->lastRequest();

        self::assertSame(
            'http://api.the-best-shop-ever.com/inventory/' . $product->id(),
            (string)$request->getUri(),
        );

        self::assertSame(
            sprintf('Bearer %s', $token->value),
            $request->getHeaderLine('Authorization'),
        );

        self::assertSame(
            sprintf('quantity=%d', $sku->quantity()),
            (string)$request->getBody(),
        );
    }
}
