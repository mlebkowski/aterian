<?php

declare(strict_types=1);

namespace Aterian\Application;

use Aterian\Domain\GuardingSalesChannelUpdater;
use Aterian\Domain\SalesChannel;
use Aterian\Domain\SalesChannelUpdater;
use Aterian\Domain\Website\WebsiteSalesChannelUpdater;
use Psr\Http\Client\ClientInterface;

final class WebsiteSalesChannelUpdaterFactory
{
    public static function make(ClientInterface $httpClient, bool $production): SalesChannelUpdater
    {
        return new GuardingSalesChannelUpdater(
            SalesChannel::Website,
            new WebsiteSalesChannelUpdater($httpClient, $production),
        );
    }
}
