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

require __DIR__ . '/auth.php';

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/', 'App\Http\Controllers\AlbumController@index')
    ->name('home');

Route::get('/search', 'App\Http\Controllers\AlbumController@search')
    ->name('search');

Route::group(
    [
        'middleware' => ['auth']
    ], function () {

    Route::get('/profile', function () {
        return view('profile');
    })->name('profile');

    Route::group(
        [
            'prefix' => 'album',
            'as' => 'album'
        ], function () {

        Route::get('/find', function () {
            return view('albumFind');
        })->name('Find');

        Route::get('/create', function () {
            return view('albumCreate');
        })->name('Create');

        Route::get('/{id}/update', 'App\Http\Controllers\AlbumController@edit')
            ->name('Specific-update');

        Route::get('/{id}/delete', 'App\Http\Controllers\AlbumController@delete')
            ->name('Specific-delete');

        Route::post('/{id}/update/submit', 'App\Http\Controllers\AlbumController@update')
            ->name('Specific-update-submit');

        Route::post('/create', 'App\Http\Controllers\ApiController@getAlbumApiData')
            ->name('Find-form');

        Route::post('/create/submit', 'App\Http\Controllers\AlbumController@store')
            ->name('Create-submit');

    }

    );

}
);

Route::group(
    [
        'prefix' => 'album',
        'as' => 'album'
    ], function () {

}

);








