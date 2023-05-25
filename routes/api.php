<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// routes/api.php

Route::post('/register', 'API\Auth\RegisterController@register')->name('register');
Route::post('/login', 'API\Auth\RegisterController@login')->name('login');
Route::get('/user', 'API\Auth\RegisterController@getUser')->name('user');
