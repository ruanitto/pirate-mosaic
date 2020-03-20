<?php

namespace App\Http\Controllers;

use App\Dream;
use App\Employee;
use Illuminate\Http\Request;

class WelcomeController extends Controller
{
    public function __invoke(Request $request)
    {
        $phoneImg = $this->phoneImg();
        $employeeCount = Employee::count();
        $dreamCount = Dream::count();
        $percentage = $employeeCount === 0 || $dreamCount === 0 ? 0 : round(($employeeCount / $dreamCount) /100);

        return view('welcome', compact('phoneImg', 'percentage'));
    }

    protected function phoneImg()
    {
        return asset('images/celphone/' . random_int(1, 20) . '.jpg');
    }
}
