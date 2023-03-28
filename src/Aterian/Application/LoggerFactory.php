<?php

declare(strict_types=1);

namespace Aterian\Application;

use Aterian\Domain\Logger\Logger;
use Aterian\Infrastructure\DevLogger;
use Aterian\Infrastructure\Logger as ProdLogger;

final class LoggerFactory
{
    public function make(): Logger
    {
        $production = 'prod' === getenv('APP_ENV');
        return $production ? new ProdLogger() : new DevLogger();
    }
}
