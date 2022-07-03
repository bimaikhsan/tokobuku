<?php

/** @var \Laravel\Lumen\Routing\Router $router */

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    return $router->app->version();
});
$router->group(['prefix' => 'transaksi'], function() use ($router)
{
    $router->get('/', 'TransaksiController@index');
    $router->post('/tambah', 'TransaksiController@store');
    $router->get('/lihat/{id}', 'TransaksiController@show');
    $router->get('/lihatid/{id}', 'TransaksiController@lihat');
    $router->put('/update/{id}', 'TransaksiController@update');
    $router->delete('/hapus/{id}', 'TransaksiController@destroy');
    
});
$router->group(['prefix' => 'buku'], function() use ($router)
{
    $router->get('/', 'BukuController@index');
    $router->post('/tambah', 'BukuController@store');
    $router->get('/lihat/{id}', 'BukuController@show');
    $router->put('/update/{id}', 'BukuController@update');
    $router->delete('/hapus/{id}', 'BukuController@destroy');
    $router->post('/try', 'BukuController@try');
});
$router->group(['prefix' => 'user'], function() use ($router)
{
    $router->get('/', 'UserController@index');
    $router->post('/tambah', 'UserController@store');
    $router->get('/lihat/{id}', 'UserController@show');
    $router->put('/update/{id}', 'UserController@update');
    $router->delete('/hapus/{id}', 'UserController@destroy');
    $router->post('/login', 'UserController@login');
    $router->post('/resetpass/{id}', 'UserController@resetpass');
    $router->get('/cektoken/{token}/{id}', 'UserController@cektoken');
});




