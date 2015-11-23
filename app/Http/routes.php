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

Route::post('/register/uploadPhoto/{patient_id}','PatientController@uploadPhoto');

Route::get('/patient/{patient_id}/picture','PatientController@getPhoto');

//-------DoctorTimeController--------------
//Route::post('/addDoctorTime','DoctorTimeController@addDoctorTime');

Route::get('/doctor/{doctor_id}/appointments','DoctorTimeController@getDoctorAppointment');

Route::get('/doctor/{doctor_id}/doctor-time','DoctorTimeController@getByDoctor');

//Route::post('/doctor/update-doctor-time/{doctor_time_id}','DoctorTimeController@editDoctorTime');

Route::post('/doctor/update-doctor-time','DoctorTimeController@editDoctorTime');

Route::post('/doctor/create-doctor-time','DoctorTimeController@makeDoctorTime');

Route::post('/doctor/delete-doctor-time/{doctor_time_id}','DoctorTimeController@deleteDoctorTime');

//------HospitalEmployee------
Route::post('/register-employee','HospitalEmployeeController@registerEmployee');

Route::get('/register-employee/username-exists/{username}','HospitalEmployeeController@usernameExist');

Route::post('/register-employee/upload-photo/{emp_id}','HospitalEmployeeController@uploadPhoto');

Route::get('/hospital-employee/{emp_id}/photo','HospitalEmployeeController@getPhoto');

//-------DoctorContorller-----------

//-------MakeAppointmentController-----------

Route::get('/find-options/doctor/{doctor_id}','MakeAppointmentController@getFreeSlotByDoctor');

Route::get('/find-options/specialty/{specialty}','MakeAppointmentController@getFreeSlotBySpecialty');

Route::post('/deleteAppointment','MakeAppointmentController@deleteAppointment');

Route::get('/getAppointmentPatient','MakeAppointmentController@getAppointmentPatient');

Route::get('/getAppointmentDoctor','MakeAppointmentController@getAppointmentDoctor');

Route::get('/getAppointmentStaff','MakeAppointmentController@getAppointmentStaff');

Route::post('/appointment/make','MakeAppointmentController@makeAppointment');

Route::post('/appointment/delete/{appointment_id}','MakeAppointmentController@deleteAppointment');
 
Route::get('/doctor','MakeAppointmentController@doctor');


//-------StaffEditController-----------
Route::get('/staff/get-patient','StaffEditController@getPatient');

Route::get('/staff/get-unconfirmed-staff','StaffEditController@getUnconfirmedStaff');

Route::post('/staff/approve-staff/{emp_id}','StaffEditController@approveStaff');

Route::post('/staff/discard-staff/{emp_id}','StaffEditController@discardStaff');

//-------NurseController-----------
Route::get('/nurse/get-patient/','NurseController@getPatient');

Route::post('/nurse/patient-report/{patient_id}','NurseController@patientReport');

