<?php

declare(strict_types=1);

namespace Allegro;

use Throwable;

interface AllegroSellerSdk
{
    /**
     * @throws Throwable
     */
    public function setInventory(string $accessToken, AllegroSellerSdk\AllegroInventory $inventory): void;
}
