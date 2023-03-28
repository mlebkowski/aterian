<?php

declare(strict_types=1);

namespace Allegro;

use Closure;
use RuntimeException;

final class AllegroSellerSdkSpy implements AllegroSellerSdk
{
    /** @var array<array<mixed>> */
    public array $calls = [];

    public static function some(): self
    {
        return new self();
    }

    public static function throwing(): self
    {
        return new self(
            static function () {
                throw new RuntimeException();
            },
        );
    }

    private function __construct(private readonly ?Closure $behaviour = null)
    {
    }

    public function setInventory(string $accessToken, AllegroSellerSdk\AllegroInventory $inventory): void
    {
        $this->calls[] = [
            'accessToken' => $accessToken,
            'id' => $inventory->id,
            'quantity' => $inventory->quantity,
        ];

        $behaviour = $this->behaviour;
        if ($behaviour) {
            $behaviour();
        }
    }
}
