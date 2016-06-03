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
//get
Route::get('complain/locations','ComplainController@get_locations');
Route::get('complain/assign','ComplainController@assign')->name('complain.assign');
Route::get('complain/{complain}/assign_staff','ComplainController@assign_staff')->name('complain.assign_staff');
Route::get('complain/{id}/actions','ComplainController@action')->name('complain.action');
Route::get('/home', 'HomeController@index');

//put
Route::put('complain/assign/{complain}','ComplainController@update_assign_staff')->name('complain.update_assign_staff');
Route::put('complain/action/{complain}','ComplainController@update_action')->name('complain.update_action');
Route::put('complain/verify/{complain}','ComplainController@verify')->name('complain.verify');
Route::resource('complain','ComplainController');
Route::auth();

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(['prefix' => 'admin'], function () {
    Route::resource('users', 'Admin\AdminUsersController');
    Route::resource('roles', 'Admin\AdminRolesController');
    Route::resource('permissions', 'Admin\AdminPermissionsController');
});
