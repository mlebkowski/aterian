<?php

declare(strict_types=1);

namespace Aterian\Domain;

final class Product
{
    private readonly string $id;
    private readonly array $channels;

    public function __construct(SalesChannel ...$channels)
    {
        // todo:
        $this->id = (string)rand(1, 1000);
        $this->channels = $channels;
    }

    public function isSoldOn(SalesChannel $channel): bool
    {
        return in_array($channel, $this->channels, true);
    }

    public function id(): string
    {
        return $this->id;
    }
}
