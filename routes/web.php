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
    return view('home');
})->name('home');

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth'])->name('dashboard');

Route::get('/album/find', function () {
    return view('albumFind');
})->middleware(['auth'])->name('albumFind');

Route::get('/album/create', function () {
    return view('albumCreate');
})->middleware(['auth'])->name('albumCreate');



Route::get('/', 'App\Http\Controllers\ApiController@allData')->name('home');

Route::get('/album/{id}/update', 'App\Http\Controllers\ApiController@updateAlbum')->name('specificAlbum-update');
Route::get('/album/{id}/delete', 'App\Http\Controllers\ApiController@deleteAlbum')->name('specificAlbum-delete');

Route::get('/album/{id}', 'App\Http\Controllers\ApiController@showSpecificAlbum')->name('specificAlbum');

Route::post('/album/{id}/update/submit', 'App\Http\Controllers\ApiController@updateAlbumSubmit')->name('specificAlbum-update-submit');
Route::post('/album/create', 'App\Http\Controllers\ApiController@getApiData')->name('albumFind-form');

Route::post('/album/create/submit', 'App\Http\Controllers\ApiController@submit')->name('albumCreate-form');

require __DIR__.'/auth.php';
