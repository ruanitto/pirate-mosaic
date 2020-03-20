<?php

namespace App\Http\Controllers;

use App\Employee;
use Illuminate\Http\Request;

class DreamController extends Controller
{
    public function store(Employee $employee, Request $request)
    {
        if ($employee->dreams->count() > 0) {
            return $this->update($employee, $request);
        }

        $request->validate([
            'realized' => ['required'],
            'realize' => ['required'],
            'terms' => ['required'],
        ]);

        // upload image
        $imagePath = $this->storeFile($request);

        $dream = $employee->dreams()->create([
            'realized' => $request->realized,
            'realize' => $request->realize,
            'image' => $imagePath,
        ]);

        return response()->json([
            'dream' => $employee->dreams->first(),
        ], 201);
    }

    public function update(Employee $employee, Request $request)
    {
        $request->validate([
            'realized' => ['required'],
            'realize' => ['required'],
            'terms' => ['required'],
        ]);

        // check if change image
        $imagePath = $this->storeFile($request);

        $employee->dreams()->first()->update([
            'realized' => $request->realized,
            'realize' => $request->realize,
            'image' => $imagePath,
        ]);

        return response()->json([
            'dream' => $employee->fresh()->dreams->first(),
        ], 201);
    }

    protected function storeFile(Request $request)
    {
        $fileFolder = public_path('uploads/dreams');

        if (!is_dir($fileFolder)) {
            mkdir($fileFolder, 0775, $recursive = true);
        }

        $data = explode(',', $request->img);
        $content = base64_decode($data[1]);
        $fileName = md5(now()) . '.jpg';
        $filePath = $fileFolder . '/' . $fileName;
        $file = fopen($filePath, "wb");
        fwrite($file, $content);
        fclose($file);

        return str_replace(public_path(), '', $filePath);
    }
}
