<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Dream;
use App\Employee;

class RegistersController extends Controller
{
    public function index()
    {
        $dreams = Dream::select([
            'dreams.id as id',
            'employees.nome as employee_nome',
            'employees.cpf as employee_cpf',
            'employees.email as employee_email',
            'employees.cargo as employee_position',
        ])
            ->join('employees', 'employees.id', 'dreams.employee_id')
            ->when(request('q'), function ($builder) {
                $builder->where('employees.nome', 'like', '%' . request('q') . '%')
                    ->where('employees.email', 'like', '%' . request('q') . '%')
                    ->orWhere('employees.cpf', 'like', '%' . request('q') . '%');
            })
            ->when(request('cargo'), function ($builder) {
                $builder->where('employees.cargo', request('cargo'));
            })
            ->paginate();

        $positions = Employee::select(['cargo'])->groupBy('cargo')->get();

        return view('dreams.index', compact('dreams', 'positions'));
    }

    public function show(Dream $dream)
    {
        return view('dreams.show', compact('dream'));
    }
}
