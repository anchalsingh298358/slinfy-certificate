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

Route::post('login', 'api\UserController@login');
Route::post('register', 'api\UserController@register');

Route::group(['middleware' => 'auth:api'], function () {
	//Get Own Profile
    Route::get('get_own_profile', 'api\UserController@get_own_profile');

    //Upload Profile
    Route::Post('upload_profile', 'api\UserController@upload_profile');

    //Update Own Data
    Route::Post('update_own_data', 'api\UserController@update_own_data');

    //Get Course List
    Route::get('course_list', 'api\UserController@course_list');

    //Get Department List
    Route::get('department_list', 'api\UserController@department_list');
});
