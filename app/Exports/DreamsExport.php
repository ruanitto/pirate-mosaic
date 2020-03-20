<?php

namespace App\Exports;

use App\Dream;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;

class DreamsExport implements FromQuery, WithHeadings
{
    public function headings(): array
    {
        return [
            'Nome',
            'CPF',
            'E-mail',
            'Cargo',
        ];
    }

    /**
     * @return Builder
     */
    public function query()
    {
        return $dreams = Dream::select([
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
            });
    }
}
