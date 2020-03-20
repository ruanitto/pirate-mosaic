<?php

namespace App\Services;

use Firebase\JWT\JWT;

class GenerateJsonWebToken implements TokenService
{
    public function getToken($user, $expiresAt)
    {
        return JWT::encode([
            'cpf' => $user->cpf,
            'exp' => $expiresAt,
        ], config('app.key'));
    }

    public function tokenData($jwt)
    {
        return JWT::decode($jwt, config('app.key'), ['HS256']);
    }
}
