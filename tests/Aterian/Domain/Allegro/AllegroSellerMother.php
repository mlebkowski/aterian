<?php

declare(strict_types=1);

namespace Aterian\Domain\Allegro;

final class AllegroSellerMother
{
    public static function some(): AllegroSeller
    {
        return new AllegroSeller();
    }
}
