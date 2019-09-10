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

Route::resource('companies', 'CompanyController',['only' => ['store','index','destroy']]);
Route::resource('groups', 'GroupController',['only' => ['store','index','destroy']]);
Route::resource('items', 'ItemController',['only' => ['store','index','destroy']]);
Route::resource('subitems', 'SubitemController',['only' => ['store','index','destroy']]);
Route::resource('customerguarantees', 'CustomerGuaranteeController',['only' => ['store','index','destroy']]);
Route::resource('rootguarantees', 'RootGuaranteeController',['only' => ['store','index','destroy']]);

Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'guarantees' => 'GuaranteeController',
        'maintenances' => 'MaintenanceController',
        'condominiums' => 'CondominiumController'
    ]);
});
