<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::group(['middleware' => ['auth', 'verified']], function() {

    Route::get('/establecimiento/create', 'EstablecimientoController@create')->name('establecimiento.create');
    Route::post('/establecimiento', 'EstablecimientoController@store')->name('establecimiento.store');
    Route::get('/establecimiento/edit', 'EstablecimientoController@edit')->name('establecimiento.edit');

    Route::post('/imagenes/store', 'ImageController@store')->name('images.store');
    Route::post('/imagenes/destroy', 'ImageController@destroy')->name('images.destroy');
});
