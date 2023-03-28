<?php

declare(strict_types=1);

namespace Aterian\Domain;

use Exception;
use Throwable;

final class SalesChannelUpdaterException extends Exception
{
    public static function fromOther(Throwable $e): self
    {
        return new self($e->getMessage(), 0, $e);
    }
}
