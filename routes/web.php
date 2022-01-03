<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

/************************************************************************************
* Home Controller
************************************************************************************/
Route::get('/home', 'HomeController@index')->name('home');

/************************************************************************************
* User Controller
************************************************************************************/
Route::get('/', 'admin\AdminController@index');

Route::group(['middleware' => ['auth'], 'prefix' => 'admin', 'as' => 'admin.'], function () {

    /************************************************************************************
     * Role Controller
     ************************************************************************************/
    Route::resource('roles','admin\RoleController');

	/************************************************************************************
     * Dashboard Controller
     ************************************************************************************/
	Route::get('dashboard', 'admin\DashboardController@index')->name('dashboard');

	/************************************************************************************
     * User Controller
     ************************************************************************************/
    Route::resource('users','admin\UserController');

    /************************************************************************************
     * Admin Controller
     ************************************************************************************/
    Route::resource('account','admin\AdminController');
    Route::post('update_password', 'admin\AdminController@update_password')->name('account.update.password');

    /************************************************************************************
     * Technology Controller
     ************************************************************************************/
    Route::resource('technology','admin\TechnologyController');
    Route::get('technology/{id}/{status}','admin\TechnologyController@update_status')->name('technology.status');
    Route::get('technology_list','admin\TechnologyController@technology_list')->name('technology.data.json');

    /************************************************************************************
     * Duration Controller
     ************************************************************************************/
    Route::resource('durations','admin\DurationController');
    Route::get('durations/{id}/{status}','admin\DurationController@update_status')->name('durations.status');
    Route::get('duration_list','admin\DurationController@duration_list')->name('durations.data.json');

    /************************************************************************************
     * Batch Controller
     ************************************************************************************/
    Route::resource('batches', 'admin\BatchController');
    Route::get('batch_list', 'admin\BatchController@batch_list')->name('batches.list.json');
    Route::get('batch/status/{id}/{status}',
        'admin\BatchController@update_status')->name('batches.status');

    /************************************************************************************
     * Student Controller
     ************************************************************************************/
	Route::resource('students', 'admin\StudentController');
	Route::get('student_list', 'admin\StudentController@student_list')->name('student.list.json');
	Route::get('student/status/{id}/{status}',
        'admin\StudentController@update_status')->name('students.status');
    
    Route::get('student/import', 'admin\StudentController@import_form')->name('student.import.form');
    Route::post('student/import', 'admin\StudentController@import_student')->name('student.import.data');

    Route::get('student/certificate/{studentId}', 'admin\StudentController@studentCertificate')->name('student.certificate');

    /************************************************************************************
     * Certificate Controller
     ************************************************************************************/
    Route::resource('certificates', 'admin\CertificateController');
    Route::get('certificate_student_list', 'admin\CertificateController@certificate_student_list')->name('certificate.list.json');
});

Auth::routes();
