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

Route::resource('companies', 'CompanyController');
Route::resource('groups', 'GroupController');
Route::resource('items', 'ItemController');
Route::resource('subitems', 'SubitemController');
Route::resource('customerguarantees', 'CustomerGuaranteeController');
Route::resource('rootguarantees', 'RootGuaranteeController');
Route::resource('rootmaintenances', 'RootMaintenanceController');
Route::resource('rootguaranteemaintenances', 'RootGuaranteeMaintenanceController');
Route::resource('condominiums','CondominiumController');
Route::resource('maintenances','MaintenanceController');
Route::resource('maintenanceprograms','MaintenanceProgramController');




Route::name('get_root_guarantees')->post('get_root_guarantees','RootGuaranteeController@getRootGuarantees');
Route::name('get_root_maintenances')->post('get_root_maintenances','RootMaintenanceController@getRootMaintenances');
Route::name('get_root_maintenance_groups')->post('get_root_maintenance_groups','RootMaintenanceController@getGroupsRootMaintenance');
Route::name('get_root_maintenance_items')->post('get_root_maintenance_items','RootMaintenanceController@getItemsRootMaintenance');
Route::name('get_root_maintenance_values')->post('get_root_maintenance_values','RootMaintenanceController@getValuesRootMaintenance');

Route::name('get_condominiums')->post('get_condominiums','CondominiumController@getComdominiums');
Route::name('get_root_guarantee_maintenances')->post('get_root_guarantee_maintenances','RootGuaranteeMaintenanceController@getRootGuaranteeMaintenances');
Route::name('allocate_guarantees_and_maintenances')->post('allocate_guarantees_and_maintenances','AllocateGuaranteesAndMaintenances@allocateGuaranteesAndMaintenances');
Route::name('allocates')->post('allocates','AllocateGuaranteesAndMaintenances@allocates');
Route::name('get_allocateds')->post('get_allocateds','CustomerGuaranteeController@getAllocateds');
Route::name('get_maintenace_programs')->post('get_maintenace_programs','MaintenanceProgramController@getMaintenancePrograms');

Route::name('user_assignments')->post('user_assignments','UserController@saveUserAndAssignments');
Route::name('user_assignments')->get('user_assignments','UserController@getUsersAndAssignments');
Route::name('user_assignments')->put('user_assignments/{id}','UserController@updateUserAndAssignments');
Route::name('user_assignments')->delete('user_assignments/{id}','UserController@deleteUserAndAssignments');
Route::name('user_assignments')->get('user_assignments/{id}','UserController@showUserAndAssignments');


//Companu Routes
//------------------------------------------------------

Route::resource('finishgroups', 'FinishGroupController');
Route::resource('finishitems', 'FinishItemController');
Route::resource('finishes', 'FinishController');
Route::resource('attendances', 'AttendanceController');

Route::name('get_attendances')->post('get_attendances','AttendanceController@getAttendances');

Route::name('get_finishes')->post('get_finishes','FinishController@getFinishs');

Route::name('get_finish_groups')->post('get_finish_groups','FinishGroupController@getFinishGroups');

Route::name('get_finish_items')->post('get_finish_items','FinishItemController@getFinishItems');

//------------------------------------------------------



//Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'guarantees' => 'GuaranteeController',
        //'maintenances' => 'MaintenanceController'
        //'condominiums' => 'CondominiumController'
    ]);
//});
