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

Route::resource('companies', 'CompanyController',['only' => ['store','index','destroy','update']]);
Route::resource('groups', 'GroupController',['only' => ['store','index','destroy','update']]);
Route::resource('items', 'ItemController',['only' => ['store','index','destroy','update']]);
Route::resource('subitems', 'SubitemController',['only' => ['store','index','destroy','update']]);
Route::resource('customerguarantees', 'CustomerGuaranteeController',['only' => ['store','index','destroy','update']]);
Route::resource('rootguarantees', 'RootGuaranteeController',['only' => ['store','index','destroy','update']]);
Route::resource('rootmaintenances', 'RootMaintenanceController',['only' => ['store','index','destroy','update']]);
Route::resource('rootguaranteemaintenances', 'RootGuaranteeMaintenanceController',['only' => ['store','index','destroy','update']]);
Route::resource('condominiums','CondominiumController',['only' => ['store','index','destroy','update']]);
Route::resource('maintenances','MaintenanceController',['only' => ['store','index','destroy','update']]);



Route::name('get_root_guarantees')->post('get_root_guarantees','RootGuaranteeController@getRootGuarantees');
Route::name('get_condominiums')->post('get_condominiums','CondominiumController@getComdominiums');
Route::name('get_root_guarantee_maintenances')->post('get_root_guarantee_maintenances','RootGuaranteeMaintenanceController@getRootGuaranteeMaintenances');

Route::name('user_assignments')->post('user_assignments','UserController@saveUserAndAssignments');
Route::name('user_assignments')->get('user_assignments','UserController@getUsersAndAssignments');
Route::name('user_assignments')->put('user_assignments/{id}','UserController@updateUserAndAssignments');
Route::name('user_assignments')->delete('user_assignments/{id}','UserController@deleteUserAndAssignments');
//Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'guarantees' => 'GuaranteeController',
        //'maintenances' => 'MaintenanceController'
        //'condominiums' => 'CondominiumController'
    ]);
//});
