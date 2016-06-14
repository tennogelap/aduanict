<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
| Start editing 23/05/2016
*/

/* Start routes Modul Aduan ICT**********************************************************/

Route::get('/', function(){
            return view('welcome');
        });
//check session route
Route::get('check_session','Auth\AuthController@check_session')->name('check_session');

//get
Route::get('/home', 'HomeController@index');
Route::get('complain/locations','ComplainController@get_locations')->name('complain.locations');
Route::get('complain/assets','ComplainController@get_assets')->name('complain.assets');
//unit manager
Route::get('complain/assign','ComplainController@assign')->name('complain.assign');
Route::get('complain/{complain}/assign_staff','ComplainController@assign_staff')->name('complain.assign_staff');
//helpdesk
Route::get('complain/{complain}/actions','ComplainController@action')->name('complain.action');
//technical action
Route::get('complain/{complain}/technical_action','ComplainController@technical_action')->name('complain.technical_action');

//put
Route::put('complain/assign/{complain}','ComplainController@update_assign_staff')->name('complain.update_assign_staff');
Route::put('complain/action/{complain}','ComplainController@update_action')->name('complain.update_action');
Route::put('complain/technical_action/{complain}','ComplainController@update_technical_action')->name('complain.update_technical_action');
Route::put('complain/verify/{complain}','ComplainController@verify')->name('complain.verify');
Route::resource('complain','ComplainController');
Route::auth();

/***********************************************
 *Report Routes
 **********************************************/
Route::get('reports/monthly_statistic_aduan_ict','ReportController@monthly_statistic_aduan_ict')->name('reports.monthly_statistic_aduan_ict');
Route::get('reports/monthly_statistic_table_aduanict','ReportController@monthly_statistic_table_aduanict')->name('reports.monthly_statistic_table_aduanict');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(['prefix' => 'admin'], function () {
    Route::resource('users', 'Admin\AdminUsersController');
    Route::resource('roles', 'Admin\AdminRolesController');
    Route::resource('permissions', 'Admin\AdminPermissionsController');
});
