<?php

declare(strict_types=1);

namespace Aterian\Domain\Website;

use Aterian\Domain\GuardingSalesChannelUpdater;
use Aterian\Domain\Http\HttpClient;
use Aterian\Domain\SalesChannel;
use Aterian\Domain\SalesChannelUpdater;

final class WebsiteSalesChannelUpdaterFactory
{
    public static function make(WebsiteToken $token, HttpClient $httpClient): SalesChannelUpdater
    {
        return new GuardingSalesChannelUpdater(
            SalesChannel::Website,
            new WebsiteSalesChannelUpdater($token, $httpClient),
        );
    }
}
