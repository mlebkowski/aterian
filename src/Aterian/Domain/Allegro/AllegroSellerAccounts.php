<?php

declare(strict_types=1);

namespace Aterian\Domain\Allegro;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @phpstan-implements IteratorAggregate<int|string,AllegroSeller>
 */
final class AllegroSellerAccounts implements IteratorAggregate
{
    /** @var AllegroSeller[] */
    private readonly array $sellers;

    public function __construct(AllegroSeller ...$seller)
    {
        $this->sellers = $seller;
    }

    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->sellers);
    }
}
