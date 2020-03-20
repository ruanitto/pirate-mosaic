<?php

namespace App\Services;

interface TokenService
{
    public function getToken($user, $expiresAt);

    public function tokenData($jwt);
}
