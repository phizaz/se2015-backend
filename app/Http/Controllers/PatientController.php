<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Patient;
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
      $status = $request->input('status');
      $remark = $request->input('remark');
      $priority = $request->input('priority');
      
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
      if($status == null)
          $error[] = 'status_not_found';
      if($remark == null)
          $error[] = 'remark_not_found';
      if($priority == null)
          $error[] = 'priority_not_found';
      
      
      $patient = new Patient;
      
      $patient->personal_id = $personal_id;
      $patient->firstname = $firstname;
      $patient->lastname = $lastname;
      $patient->birthdate = $birthdate;
      $patient->address = $address;
      $patient->gender = $gender;
      $patient->religion = $religion;
      $patient->nationality = $nationality;
      $patient->bloodtype = $bloodtype;
      $patient->status = $status;
      $patient->remark = $remark;
      $patient->priority = $priority;
      
      $patient->password = Hash::make($password);
      if(sizeof($error)==0) {
        $patient->save();
        return response()->json(["success" => true,
                              "data" => array($patient)
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
