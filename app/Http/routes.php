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

Route::resource('complain','ComplainController');

Route::auth();

Route::get('/home', 'HomeController@index');

