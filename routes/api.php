<?php

use Illuminate\Http\Request;

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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::post('login', 'AuthController@login');
Route::post('logout', 'AuthController@logout');
Route::post('refresh', 'AuthController@refresh');
Route::get('me', 'AuthController@me');

Route::get('roles', 'RoleController@index');
Route::post('roles', 'RoleController@store');

Route::post('users', 'UserController@store');
Route::get('users', 'UserController@index');

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'guarantees' => 'GuaranteeController',
        'maintenances' => 'MaintenanceController'
    ]);
});
