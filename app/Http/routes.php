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
*/

Route::get('/', 'HomeController@index');

Route::get('/is-login','UserController@islogin');

Route::post('/login', 'UserController@login');

Route::post('/logout', 'UserController@logout');

Route::post('/register', 'PatientController@register');

Route::get('/username-exists','PatientController@isExists');

Route::post('/addDoctorTime','UserController@addDoctorTime');

Route::post('/getByDoctor','DoctorTime@getByDoctor');

Route::post('/register-employee','HospitalEmployeeController@registerEmployee');

Route::get('/register-employee/username-exists','HospitalEmployeeController@usernameExist');

Route::post('/register-employee/upload-photo/{emp_id}','HospitalEmployeeController@uploadPhoto');

Route::get('/hospital-employee/{emp_id}/photo','HospitalEmployeeController@getPhoto');

Route::get('/doctor','DoctorController@doctor');
