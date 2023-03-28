<?php

declare(strict_types=1);

namespace Aterian\Infrastructure;

use Aterian\Domain\Http\HttpClient;
use GuzzleHttp\Psr7\Request;
use Psr\Http\Message\RequestInterface;
use RuntimeException;

final class HttpClientSpy implements HttpClient
{
    /** @var RequestInterface[] */
    public array $requests = [];

    public function lastRequest(): RequestInterface
    {
        $request = end($this->requests);
        if (false === $request instanceof RequestInterface) {
            throw new RuntimeException('No requests recorded');
        }

        return $request;
    }

    public function request(string $token, string $url, array $payload): void
    {
        // it’s test sources
        // I didn’t want to introduce a new VO, so I’m using guzzle’s request
        $this->requests[] = new Request(
            'GET',
            $url,
            ['Authorization' => sprintf("Bearer %s", $token)],
            http_build_query($payload),
        );
    }
}
