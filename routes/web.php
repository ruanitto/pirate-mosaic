<?php

use Illuminate\Support\Facades\Route;

Route::get('', 'WelcomeController')->name('welcome');

Auth::routes();

Route::get('dashboard', 'DashboardController@index')->name('dashboard')->middleware(['auth']);

Route::get('cadastros', 'RegistersController@index')->name('registers');
Route::get('cadastros/exportar', 'ExportRegistersController')->name('export');
Route::get('cadastros/{dream}', 'RegistersController@show')->name('registers.show');

Route::get('usuarios', 'UsersController@index')->name('users.index');
Route::get('usuarios/criar', 'UsersController@create')->name('users.create');
Route::post('usuarios/criar', 'UsersController@store')->name('users.store');
Route::get('usuarios/{user}', 'UsersController@edit')->name('users.edit');
Route::put('usuarios/{user}', 'UsersController@update')->name('users.update');
Route::post('usuarios/ativar/{user}', 'UsersActiveController@store')->name('users.activate');
Route::delete('usuarios/desativar/{user}', 'UsersActiveController@destroy')->name('users.deactivate');
