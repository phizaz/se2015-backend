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

//--------UserController----------
Route::get('/is-login','UserController@islogin');

Route::post('/login', 'UserController@login');

Route::post('/logout', 'UserController@logout');


//-------PatientController-------------
Route::post('/register', 'PatientController@register');

Route::get('/username-exists','PatientController@isExists');


//-------DoctorTimeController--------------
Route::get('/getByDoctor','DoctorTimeController@getByDoctor');

Route::post('/addDoctorTime','DoctorTimeController@addDoctorTime');

//------HospitalEmployee------
Route::post('/register-employee','HospitalEmployeeController@registerEmployee');

Route::get('/register-employee/username-exists','HospitalEmployeeController@usernameExist');

//-------MakeAppointmentController-----------
Route::get('/test','MakeAppointmentController@test'); //test

Route::post('/makeAppointment','MakeAppointmentController@makeAppointment');

Route::post('/deleteAppointment','MakeAppointmentController@deleteAppointment');

Route::get('/getAppointmentPatient','MakeAppointmentController@getAppointmentPatient');

Route::get('/getAppointmentDoctor','MakeAppointmentController@getAppointmentDoctor');

Route::get('/getAppointmentStaff','MakeAppointmentController@getAppointmentStaff');
