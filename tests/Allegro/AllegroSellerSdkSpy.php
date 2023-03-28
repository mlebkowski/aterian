<?php

declare(strict_types=1);

namespace Allegro;

final class AllegroSellerSdkSpy implements AllegroSellerSdk
{
    public array $calls = [];

    public function setInventory(string $accessToken, AllegroSellerSdk\AllegroInventory $inventory): void
    {
        $this->calls = [
            'accessToken' => $accessToken,
            'id' => $inventory->id,
            'quantity' => $inventory->quantity,
        ];
    }
}
