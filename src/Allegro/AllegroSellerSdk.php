<?php

declare(strict_types=1);

namespace Allegro;

interface AllegroSellerSdk
{
    public function setInventory(string $accessToken, AllegroSellerSdk\AllegroInventory $inventory): void;
}
