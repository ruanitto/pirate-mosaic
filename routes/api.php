<?php

use Illuminate\Support\Facades\Route;

Route::post('authentication', 'AuthenticationController@store')->name('login');
Route::post('employees', 'EmployeeCpfsController')->name('employees.cpf');

Route::post('dream/{employee}', 'DreamController@store')->name('dreams')->middleware(['validation-token']);
Route::put('dream/{employee}', 'DreamController@update')->name('dreams.update')->middleware(['validation-token']);

Route::get('urls', 'ImagesUrlsController')->name('images.urls');
