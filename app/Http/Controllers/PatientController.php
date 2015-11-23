<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use App\Http\Controllers\Fileentry;

use Illuminate\Http\response;
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

      if($personal_id == null)
          $error[] = 'personal_id_not_found';
      if($password == null)
          $error[] = 'password_not_found';
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

    //----------------uploadPhoto---------------------
    public function uploadPhoto (Request $request, $patient_id){
        // $emp = HospitalEmployee::where('emp_id',$employeeId);
        if (!Patient::isPatient()){
            return response()->json([
                "success" => false
                ]);
        }

        $file = $request->file('file');
        $mime = $file->getClientMimeType();
        $name = $patient_id;
        $extension = $file->getClientOriginalExtension();

        $patient = Patient::where('id', $patient_id)->first();

        if (!$patient) {
            return response() -> json([
                'success' => false,
                'message' => 'patient_not_found'
                ]);
        }

        $patient->photo_extension = $extension;
        $patient->save();

        Storage::disk('local')->put($name.'.'.$extension,  File::get($file));
        return response()->json([
            "success" => true,
            "patient_id" => $name
            ]);
    }

    //-----------------------getPhoto-----------------------------------------
    public function getPhoto($patient_id){

        $patient = Patient::where('id', $patient_id)->first();
        $file = Storage::disk('local')->get($patient_id . '.' . $patient->photo_extension);

        $ext = $patient->photo_extension;
        if ($ext == 'jpeg') {
            return (new Response($file, 200))->header('Content-Type', 'image/jpeg');
        }else if($ext == 'jpg'){
            return (new Response($file, 200))->header('Content-Type', 'image/jpeg');
        }else if($ext == 'gif'){
            return (new Response($file, 200))->header('Content-Type', 'image/gif');
        }else if($ext == 'png'){
            return (new Response($file, 200))->header('Content-Type', 'image/png');
        }

    }


}
