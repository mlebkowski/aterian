<?php

declare(strict_types=1);

namespace Aterian\Domain;

final class ProductMother
{
    public static function withSalesChannel(SalesChannel $channel): Product
    {
        return new Product($channel);
    }
}
