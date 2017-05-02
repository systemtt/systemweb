<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/

Route::get('admin', function () {
    return view('welcome');
});

Route::get('/', 'TazartController@index');

Route::get('detalle/cuadro/{id}', 'TazartController@cuadro');

Route::get('detalle/remate/{id}', 'TazartController@remate');

Route::get('nosotros', 'TazartController@nosotros');

Route::get('buscador', 'TazartController@buscador_ajax');

Route::get('buscador_art', 'TazartController@buscador_art');

Route::get('contacto', 'TazartController@contacto');

Route::get('remates', 'TazartController@remates');

Route::get('obras', 'TazartController@obras');

Route::get('artistas', 'TazartController@artistas');

Route::resource('admin/cuadro', 'CuadroController');

Route::resource('admin/slider', 'SliderController');

Route::resource('admin/remate', 'RemateController');

Route::resource('admin/obra', 'ObraController');
