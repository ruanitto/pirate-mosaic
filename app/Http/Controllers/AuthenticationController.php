<?php

namespace App\Http\Controllers;

use App\Employee;
use App\JsonWebToken;
use Illuminate\Http\Request;
use App\Services\TokenService;

class AuthenticationController extends Controller
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function store(Request $request)
    {
        $request->validate([
            'cpf' => ['required', 'exists:employees'],
            'password' => ['required', 'min:6'],
        ]);

        $user = Employee::whereCpf($request->cpf)->firstOrFail();

        if (!$user->password) {
            $user->password = bcrypt($request->password);
            $user->save();
            $user = $user->fresh();
        }

        if (!password_verify($request->password, $user->password)) {
            return response()->json([
                'message' => 'Usuário e senha não conferem!',
            ], 401);
        }

        $expiresAt = time() + (60 * 60 * config('tenda.expiration_time'));

        $jwt = JsonWebToken::create([
            'employee_id' => $user->id,
            'token' => $this->tokenService->getToken($user, $expiresAt),
            'expires_at' => now()->addHours(config('tenda.expiration_time')),
        ]);

        return response()->json([
            'token' => $jwt->token,
            'dream' => $user->dreams->first(),
        ], 200);
    }
}
