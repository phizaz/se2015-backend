<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;  //for authentication

//use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Response;
use App\Patient;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        $id = $request->input('id');
        $password = $request->input('password');
        
        if(Auth::patient().attempt(['id'=>$id,'password'=>$password])) {
            return 'Login success!';  
        }
        else
            return 'Login failed!';

        
        
    }

    public function register(Request $request) {
      
      $id = $request->input('id');
      $personal_id = $request->input('personal_id');
      $password = $request->input('password');
      $firstname = $request->input('firstname');
      $lastname = $request->input('lastname');
      $birthdate = $request->input('birthdate');
      $address = $request->input('address');
      $gender = $request->input('gender');  //M/F
      $religion = $request->input('religion');
      $nationality = $request->input('nationality');
      $bloodtype = $request->input('bloodtype');
      $status = $request->input('status'); //boolean
      $remark = $request->input('remark');
      $priority = $request->input('priority');//int 
//      
      $patient = new Patient;
//            
      $patient->id = $id;
      $patient->personal_id = $personal_id;
      $patient->password = $password;
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
      
      
      //$patient->id->save();
      $patient->save();
      
      return response()->json(array($patient));

    }
}
