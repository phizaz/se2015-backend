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
                                    "message" => ['personal_id_exist']
                                    ]);
      }
      
      $patient = new Patient;
          
      $patient->personal_id = $request->input('personal_id');
      //$patient->password = $password;
      $patient->firstname = $request->input('firstname');
      $patient->lastname = $request->input('lastname');
      $patient->birthdate = $request->input('birthdate');
      $patient->address = $request->input('address');
      $patient->gender = $request->input('gender');
      $patient->religion = $request->input('religion');
      $patient->nationality = $request->input('nationality');
      $patient->bloodtype = $request->input('bloodtype');
      $patient->status = $request->input('status');
      $patient->remark = $request->input('remark');
      $patient->priority = $request->input('priority');
      
      $patient->password = Hash::make($request->input('password'));
      
      $patient->save();
      
      return response()->json(["success" => true,
                              "data" => array($patient)
                              ]);
    }
    
//----------------isExists--------------------------
    public function isExists(Request $request) {
        if(Patient::where('personal_id',$request->input('personal_id'))->first())
            return response()->json(["found" => true]);
        else
            return response()->json(["found" => false]);
    }
}
