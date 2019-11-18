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
Route::resource('customerguaranteemaintenances', 'CustomerGuaranteeMaintenanceController');
Route::resource('rootguarantees', 'RootGuaranteeController');
Route::resource('rootmaintenances', 'RootMaintenanceController');
Route::resource('rootguaranteemaintenances', 'RootGuaranteeMaintenanceController');
Route::resource('condominiums','CondominiumController');
Route::resource('maintenances','MaintenanceController');
Route::resource('maintenanceprograms','MaintenanceProgramController');

Route::name('get_groups_by_type')->post('get_groups_by_type','GroupController@getGroupsbyType');
Route::name('get_items_from_group')->post('get_items_from_group','ItemController@getItensFromGroup');


Route::name('get_root_guarantees')->post('get_root_guarantees','RootGuaranteeController@getRootGuarantees');
Route::name('get_root_guarantees_groups')->post('get_root_guarantees_groups','RootGuaranteeController@getGroupsRootGuarantee');
Route::name('get_root_guarantees_items')->post('get_root_guarantees_items','RootGuaranteeController@getItemsRootGuarantee');


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
Route::name('get_maintenance_programs_by_month')->post('get_maintenance_programs_by_month','MaintenanceProgramController@getMaintenanceProgramsMonthGrouped');


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
Route::resource('equipmentguarantees', 'EquipmentGuaranteeController');
Route::resource('contracts', 'ContractController');
Route::resource('licenses', 'LicenseController');
Route::resource('projects', 'ProjectController');
Route::resource('manuals', 'ManualController');

Route::name('get_equipment_guarantees')->post('get_equipment_guarantees','EquipmentGuaranteeController@getEquipmenteGuarantees');

Route::name('get_attendances')->post('get_attendances','AttendanceController@getAttendances');

Route::name('get_finishes')->post('get_finishes','FinishController@getFinishs');

Route::name('get_contracts')->post('get_contracts','ContractController@getContracts');

Route::name('get_licenses')->post('get_licenses','LicenseController@getLicenses');

Route::name('get_projects')->post('get_projects','ProjectController@getProjects');

Route::name('get_manuals')->post('get_manuals','ManualController@getProjects');

Route::name('get_finish_groups')->post('get_finish_groups','FinishGroupController@getFinishGroups');

Route::name('get_finish_items')->post('get_finish_items','FinishItemController@getFinishItems');

Route::name('update_maintenance_program')->post('update_maintenance_program','MaintenanceProgramController@updateMaintenanceProgram');

Route::name('maintenance_download_file')->get('maintenance_download_file/{id}','MaintenanceProgramController@downloadFile');
Route::name('maintenance_delete_file')->post('maintenance_delete_file','MaintenanceProgramController@deleteFile');

Route::name('attendance_upload_files')->post('attendance_upload_files/{id}','AttendanceController@uploadoFiles');
Route::name('attendance_download_files')->get('attendance_download_files/{id}','AttendanceController@downloadFile');
Route::name('attendance_acceptance_term')->get('attendance_acceptance_term/{id}','AttendanceController@acceptanceTerm');

Route::name('contract_upload_file')->post('contract_upload_file','ContractController@uploadoFiles');
Route::name('contract_download_file')->get('contract_download_files/{id}','ContractController@downloadFile');
Route::name('contract_delete_file')->post('contract_delete_file','ContractController@deleteFile');
Route::name('contract_update_file')->post('contract_update_file/{id}','ContractController@updateFile');

Route::name('license_upload_files')->post('license_upload_files','LicenseController@uploadoFiles');
Route::name('license_download_files')->get('license_download_files/{id}','LicenseController@downloadFile');

Route::name('manual_upload_files')->post('manual_upload_files','ManualController@uploadoFiles');
Route::name('manual_download_files')->get('manual_download_files/{id}','ManualController@downloadFile');
Route::name('manual_delete_files')->post('manual_delete_file','ManualController@deleteFile');
Route::name('manual_update_file')->post('manual_update_file/{id}','ManualController@updateFile');

Route::name('project_upload_file')->post('project_upload_file','ProjectController@uploadFiles');
Route::name('project_download_file')->get('project_download_file/{id}','ProjectController@downloadFile');
Route::name('project_delete_file')->post('project_delete_file','ProjectController@deleteFile');
Route::name('project_update_file')->post('project_update_file/{id}','ProjectController@updateFile');

Route::name('license_upload_file')->post('license_upload_file','LicenseController@uploadoFiles');
Route::name('license_download_file')->get('license_download_file/{id}','LicenseController@downloadFile');
Route::name('license_delete_file')->post('license_delete_file','LicenseController@deleteFile');
Route::name('license_update_file')->post('license_update_file/{id}','LicenseController@updateFile');

Route::name('equipment_guarantee_upload_files')->post('equipment_guarantee_upload_files/{id}','EquipmentGuaranteeController@uploadoFiles');
Route::name('equipment_guarantee_download_files')->get('equipment_guarantee_download_files/{id}','EquipmentGuaranteeController@downloadFile');

Route::name('get_customer_guarantees')->post('get_customer_guarantees','CustomerGuaranteeController@getCustomerGuarantees');


Route::name('build_user_dashboard')->post('build_user_dashboard','UserDashboardController@buildDashboard');


//------------------------------------------------------





//Route::group(['middleware' => 'auth:api'], function () {
    Route::apiResources([
        'guarantees' => 'GuaranteeController',
        //'maintenances' => 'MaintenanceController'
        //'condominiums' => 'CondominiumController'
    ]);
//});
