<?php

declare(strict_types=1);

namespace Aterian\Domain\Website;

final class WebsiteTokenMother
{
    public static function some(): WebsiteToken
    {
        return WebsiteToken::of(md5(random_bytes(16)));
    }
}
