<?php

declare(strict_types=1);

namespace Allegro\AllegroSellerSdk;

final class AllegroInventory
{
    public function __construct(public readonly string $id, public readonly int $quantity)
    {
    }
}
