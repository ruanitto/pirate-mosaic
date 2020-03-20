<?php

namespace App\Imports;

use App\Employee;
use Maatwebsite\Excel\Concerns\ToModel;

class EmployeesImport implements ToModel
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        if ($row[0] === 'Regional') {
            return;
        }

        $cpf = $this->maskCpf($row[4]);
        if (Employee::whereCpf($cpf)->exists()) {
            return;
        }

        return new Employee([
            'nome' => $row[2],
            'cpf' => $cpf,
            'email' => $row[5],
            'cargo' => $row[3],
            'regional' => $row[0],
            'diretoria' => $row[1],
        ]);
    }

    protected function maskCpf($str)
    {
        if (strlen($str) <= 10) {
            $str = "0" . $str;
        }

        $mask = '###.###.###-##';

        $str = str_replace(' ', '', $str);

        for ($i = 0; $i < strlen($str); $i++) {
            $mask[strpos($mask, '#')] = $str[$i];
        }

        return $mask;
    }
}
