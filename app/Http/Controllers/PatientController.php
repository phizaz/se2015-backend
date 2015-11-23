<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Patient;
use App\User;
use Input;
use Auth;                    //for authentication
use Illuminate\Support\Facades\Hash;

class PatientController extends Controller
{
//-------------------register---------------------------
    public function register(Request $request) {

//---------- เช็คกรณีที่personal_id มีอยู่ในระบบแล้ว-------------
      if(Patient::where('personal_id',$request->input('personal_id'))->first()) {
          return response()->json([
                                    "success" => false,
                                    "message" => ['this_personal_id_has_been_used']
                                    ]);
      }

      $error = [];
      $personal_id = $request->input('personal_id');
      $password = $request->input('password');
      $firstname = $request->input('firstname');
      $lastname = $request->input('lastname');
      $birthdate = $request->input('birthdate');
      $address = $request->input('address');
      $gender = $request->input('gender');
      $religion = $request->input('religion');
      $nationality = $request->input('nationality');
      $bloodtype = $request->input('bloodtype');
      $tel = $request->input('tel');
      $remark = $request->input('remark');

      if(!$personal_id)
          $error[] = 'personal_id_not_found';
      if(!$password)
          $error[] = 'password_not_found';
      if(!$firstname)
          $error[] = 'firstname_not_found';
      if(!$lastname)
          $error[] = 'lastname_not_found';
      if(!$birthdate)
          $error[] = 'birthdate_not_found';
      if(!$address)
          $error[] = 'address_not_found';
      if(!$gender)
          $error[] = 'gender_not_found';
      if(!$nationality)
          $error[] = 'nationality_not_found';
      if(!$bloodtype)
          $error[] = 'bloodtype_not_found';
      if(!$tel)
          $error[] = 'tel_not_found';

      if(sizeof($error)==0) {

        $patient = Patient::create([
          'personal_id' => $personal_id,
          'password' => $password,
          'firstname' => $firstname,
          'lastname' => $lastname,
          'birthdate' => $birthdate,
          'address' => $address,
          'gender' => $gender,
          'religion' => $religion,
          'nationality' => $nationality,
          'bloodtype' => $bloodtype,
          'tel' => $tel,
          'remark' => $remark,
          ]);

        return response()->json(["success" => true,
                              "data" => $patient->toArray()
                              ]);
      }
      else {
        return response()->json(["success" => false,
                                  "message" => $error
                                ]);
      }
    }

//----------------isExists--------------------------
    public function isExists(Request $request) {
      $personal_id = $request->input('personal_id');
      if($personal_id == null)
        return response()->json(["found" => false,
                                 "message" => 'personal_id_not_found'
                                ]);

      if(Patient::where('personal_id',$request->input('personal_id'))->first())
        return response()->json(["found" => true]);
      else
        return response()->json(["found" => false]);
    }




}
