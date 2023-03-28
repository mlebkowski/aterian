<?php

declare(strict_types=1);

namespace Aterian\Domain\Http;

use Aterian\Domain\Logger\Logger;

final class LoggingHttpClient implements HttpClient
{

    public function __construct(private readonly HttpClient $inner, private readonly Logger $logger)
    {
    }

    public function request(string $token, string $url, array $payload): void
    {
        $this->logger->debug(
            sprintf(
                'Request [token: %s]: %s [payload: %s]',
                $this->anonymize($token),
                $url,
                http_build_query($payload),
            ),
        );
        $this->inner->request($token, $url, $payload);
    }

    private function anonymize(string $token): string
    {
        $cutoff = 5;
        $teaser = substr($token, 0, $cutoff);
        return $teaser . str_repeat('*', strlen($token) - $cutoff);
    }
}
