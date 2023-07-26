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
Route::post('/linkedin-callback', 'API\Auth\RegisterController@linkedin_callback')->name('linkedin_callback');

Route::put('/user/{id}', 'API\Auth\UserController@update')->name('user.update');
Route::delete('/deleteUser', 'API\Auth\UserController@destroy')->name('user.destroy');
Route::get('/get-users', 'API\Auth\UserController@index')->name('users.index');
Route::get('/get-roles', 'API\Auth\UserController@indexRoles')->name('roles.index');
Route::post('/add-roles', 'API\Auth\UserController@newRole')->name('roles.store');
Route::post('/update-role', 'API\Auth\UserController@updateRole')->name('roles.update');
Route::get('/get-user/{id}', 'API\Auth\UserController@show')->name('user.show');
Route::post('/image-upload', 'API\Auth\UserController@imageUpload')->name('user.imageUpload');
Route::post('/add-user', 'API\Auth\UserController@store')->name('user.store');

// image upload APIs
Route::get('/user/{id}/image', 'UserController@getUserImage');



