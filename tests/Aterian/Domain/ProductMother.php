<?php

declare(strict_types=1);

namespace Aterian\Domain;

final class ProductMother
{
    public static function some(): Product
    {
        return self::withBothSalesChannels();
    }

    public static function withBothSalesChannels(): Product
    {
        return new Product(SalesChannel::Website, SalesChannel::Allegro);
    }

    public static function withWebsite(): Product
    {
        return new Product(SalesChannel::Website);
    }

    public static function withAllegro(): Product
    {
        return new Product(SalesChannel::Allegro);
    }
}
