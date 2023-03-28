<?php

declare(strict_types=1);

namespace Aterian\Application;

use Aterian\Domain\Website\WebsiteToken;

final class WebsiteTokenFactory
{
    public static function make(): WebsiteToken
    {
        $token = getenv('ATR_SHOP_API_SECRET');
        assert(is_string($token), 'Missing env variable ATR_SHOP_API_SECRET');
        return WebsiteToken::of($token);
    }
}
