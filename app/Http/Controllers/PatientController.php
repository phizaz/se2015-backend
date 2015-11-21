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
                                    "message" => ['this personal_id has been used']
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

      if($personal_id == null)
          $error[] = 'personal_id_not_found';
      if($password == null)
          $error[] = 'password_id_not_found';
      if($firstname == null)
          $error[] = 'firstname_not_found';
      if($lastname == null)
          $error[] = 'lastname_not_found';
      if($birthdate == null)
          $error[] = 'birthdate_not_found';
      if($address == null)
          $error[] = 'address_not_found';
      if($gender == null)
          $error[] = 'gender_not_found';
      if($religion == null)
          $error[] = 'religion_not_found';
      if($nationality == null)
          $error[] = 'nationality_not_found';
      if($bloodtype == null)
          $error[] = 'bloodtype_not_found';
      if($tel == null)
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
        if(Patient::where('personal_id',$request->input('personal_id'))->first())
            return response()->json(["found" => true]);
        else
            return response()->json(["found" => false]);
    }
}
