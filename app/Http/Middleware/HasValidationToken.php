<?php

namespace App\Http\Middleware;

use Closure;
use App\JsonWebToken;
use App\Services\TokenService;
use Firebase\JWT\ExpiredException;

class HasValidationToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $authorization = $request->header('Authorization');

        if (!$authorization) {
            return response()->json([
                'message' => 'No authorization token provided!',
            ], 401);
        }

        $authorizationToken = str_replace('Bearer ', '', $authorization);

        try {
            $jwtAuthorization = resolve(TokenService::class)->tokenData($authorizationToken);
        } catch (ExpiredException $e) {
            return response()->json([
                'message' => 'Token has expired!',
            ], 401);
        } catch (SignatureInvalidException $e) {
            return response()->json([
                'message' => 'Invalid authentication token!',
            ], 401);
        }

        $jwt = JsonWebToken::whereToken($authorizationToken)->firstOrFail();

        $request->user = $jwt->employee;

        return $next($request);
    }
}
