<?php

namespace App\Http\Controllers;

use App\Exports\DreamsExport;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class ExportRegistersController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        return Excel::download(new DreamsExport, 'cadastros-' . now() . '.xlsx');
    }
}
