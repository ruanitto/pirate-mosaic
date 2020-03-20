<?php

namespace App\Http\Controllers;

use App\Employee;
use App\JsonWebToken;
use App\Rules\Cpf;
use App\Services\TokenService;
use Illuminate\Http\Request;

class EmployeeCpfsController extends Controller
{
    protected $tokenService;

    public function __construct(TokenService $tokenService)
    {
        $this->tokenService = $tokenService;
    }

    public function __invoke(Request $request)
    {
        $employee = Employee::whereCpf($request->cpf)->firstOrFail();

        $employee->has_password = !is_null($employee->password);

        $expiresAt = time() + (60 * 60 * config('tenda.expiration_time'));

        $jwt = JsonWebToken::create([
            'employee_id' => $employee->id,
            'token' => $this->tokenService->getToken($employee, $expiresAt),
            'expires_at' => now()->addHours(config('tenda.expiration_time')),
        ]);

        return response()->json([
            'employee' => $employee,
            'token' => $jwt->token,
            'dream' => $employee->dreams->first(),
        ]);
    }
}
