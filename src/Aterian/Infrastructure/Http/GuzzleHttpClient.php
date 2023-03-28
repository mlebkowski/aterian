<?php

declare(strict_types=1);

namespace Aterian\Infrastructure\Http;

use Aterian\Domain\Http\HttpClient;
use Aterian\Domain\Http\HttpClientException;
use GuzzleHttp\Client;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Client\ClientExceptionInterface;

final class GuzzleHttpClient implements HttpClient
{
    public function __construct(private readonly Client $guzzle)
    {
    }

    public function request(string $token, string $url, array $payload): void
    {
        try {
            $this->guzzle->sendRequest(
                new Request(
                    method: 'GET',
                    uri: $url,
                    headers: [
                        'Authorization' => sprintf('Bearer %s', $token),
                    ],
                    body: http_build_query($payload),
                ),
            );
        } catch (ClientExceptionInterface $e) {
            throw new HttpClientException($e->getMessage(), 0, $e);
        }
    }
}
