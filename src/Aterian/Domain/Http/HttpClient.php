<?php

namespace Aterian\Domain\Http;

interface HttpClient
{
    /**
     * @param array<int|string,mixed> $payload
     * @throws HttpClientException
     */
    public function request(string $token, string $url, array $payload): void;
}
