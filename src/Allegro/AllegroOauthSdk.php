<?php

declare(strict_types=1);

namespace Allegro;

interface AllegroOauthSdk
{
    public function getAccessToken(string $id, string $refreshToken): string;
}
