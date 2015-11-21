<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\User;
use App\HospitalEmployee;
use Hash;

class HospitalEmployeeController extends Controller
{
    public function registerEmployee(Request $request){
        $username = $request->input('username');
        $password = $request->input('password');
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');
        $tel = $request->input('tel');
        $email = $request->input('email');
        $role = $request->input('role');
        $specialty = $request->input('specialty');
        $valid = $request->input('valid');

        // username not repeat
        // fill all request

        $error = [];
        if(!$username){
            $error[] = 'username_not_found';
        }else if(User::where('username', $username)->first()){
            $error[] = 'username_exist';
        }
        if($password == null){
            $error[] = 'password_not_found';
        }
        if($firstname == null){
            $error[] = 'firstname_not_found';
        }
        if($lastname == null){
            $error[] = 'lastname_not_found';
        }
        if($tel == null){
            $error[] = 'tel_not_found';
        }
        if($email == null){
            $error[] = 'email_not_found';
        }
        if($role == null){
            $error[] = 'role_not_found';
        }
        if($role =='Doctor' && $specialty == null){
            $error[] = 'specialty_not_found';
        }

        if(sizeof($error) != 0){
            return response()->json([
                "success" => false,
                "message" => $error
            ]);
        }

        $prototype = [
            'username' => $username,
            'password' => $password,
            'firstname' => $firstname,
            'lastname' => $lastname,
            'tel' => $tel,
            'email' => $email,
            'role' => $role,
        ];

        if($role == 'Doctor'){
            $prototype['specialty'] = $specialty;
        }

        $employee = HospitalEmployee::create($prototype);

        return response()->json([
            "success" => true,
            "data" => $employee->toArray()
        ]);
    }

    public function usernameExist (Request $request){
        $username = $request->input('username');

        if(HospitalEmployee::where('username', $username)->first()){
            return response()->json(["found" => true ]);
        }else{
            return response()->json(["found" => false ]);
        }

    }

}
