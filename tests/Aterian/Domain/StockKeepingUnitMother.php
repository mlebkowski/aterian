<?php

declare(strict_types=1);

namespace Aterian\Domain;

final class StockKeepingUnitMother
{
    public static function some(): StockKeepingUnit
    {
        return new StockKeepingUnit(quantity: 1);
    }
}
