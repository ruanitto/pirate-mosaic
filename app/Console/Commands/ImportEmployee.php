<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Imports\EmployeesImport;
use Maatwebsite\Excel\Facades\Excel;

class ImportEmployee extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'employee:import {filePath}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import employee excel file';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        Excel::import(new EmployeesImport, $this->argument('filePath'));

        $this->info('Importado com sucesso!');
    }
}
