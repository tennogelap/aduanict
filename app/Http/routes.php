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
Route::get('complain/locations','ComplainController@get_locations');

Route::get('complain/{id}/actions','ComplainController@action')->name('complain.action');
Route::put('complain/{id}','ComplainController@update_action')->name('complain.update_action');

Route::resource('complain','ComplainController');

Route::auth();

Route::get('/home', 'HomeController@index');

/** ------------------------------------------
 *  Admin Routes
 *  ------------------------------------------
 */
Route::group(['prefix' => 'admin'], function () {
    Route::resource('users', 'Admin\AdminUsersController');
    Route::resource('roles', 'Admin\AdminRolesController');
    Route::resource('permissions', 'Admin\AdminPermissionsController');
});
