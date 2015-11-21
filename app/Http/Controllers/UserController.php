<?php

namespace App\Http\Controllers;
//use Input;
use Auth;                    //for authentication
//Illuminate\Routing\Controller; 
//use Illuminate\Auth;
//use Illuminate\Http\Request;
use Illuminate\Http\Request;
//use App\Http\Requests; 
use App\Patient;
use App\HospitalEmployee;
//use Illuminate\Support\Facades\Hash;

//use Illuminate\Support\Facades\Storage;
//use Illuminate\Support\Facades\File;
use Illuminate\Http\response;
use Hash;
use App\DoctorTime;  //ลองๆ
//use App\Http\Controllers\Controller;
//  use Illuminate\Http\Response;

class UserController extends Controller
{
     public function addDoctorTime(Request $request) { //ลองๆ
        $doctorTime = new DoctorTime();
        $doctorTime->doctor_id = $request->input('doctor_id');
        $doctorTime->doctorTime_begin = $request->input('doctorTime_begin');
        $doctorTime->doctorTime_end = $request->input('doctorTime_end');
        $doctorTime->save();
    }
    
//===============================Login==========================================
    public function islogin() {
        if(Auth::check()) {
            return response()->json(["login" => true,
                                     "data" => Auth::user()->toArray()
                                    ]);
        } else
            return response()->json(["login" => false
                                    ]);
    } 
// kuy foun
    public function login(Request $request) {
        $users = null;
        //$personal_id = $request->input('personal_id');
        $username = $request->input('username');
        if($username==null) 
            return response()->json(["success" => false,
                                    "message" => 'username_not_found'
                                    ]);

        $password = $request->input('password');
        if($password==null) 
            return response()->json(["success" => false,
                                    "message" => 'password_not_found'
                                    ]);
        $users = Patient::where('personal_id',$username)->first();
        if($users==null) {
            $users = HospitalEmployee::where('username',$username)->first();
        }
       

        if($users) {
            if(Hash::check($password,$users->password)) {   //กรณี Login สำเร็จ
                    Auth::login($users);
                    return response()->json(["success" => true,
                                             "login" => true,
                                             "data" => array(Auth::user())
                                            ]);
            }
            else {                                     //กรณี Password ผิด
                return response()->json(["success" => false,
                                         "message" => 'wrong_password'
                                        ]);
            }
        }
        else {                                            //กรณี user ไม่ได้อยู่ใน database
            return response()->json(["succes" => false,
                                     "message" => 'this_user_does_not_exist_in_database'
                                    ]);
        }
    }
    
//===============================Logout==========================================    
    
    public function logout(Request $request) {
        $users = null;
        $username = $request->input('username');
        if($username==null){
            return response()->json(["success" => false,
                                     "message" => 'username_not_found'
                                    ]);
        }   
        $users = Patient::where('personal_id',$username)->first();
        if($users==null) {
            $users = HospitalEmployee::where('username',$username)->first();
        }
        
        if($users) {
            if(Auth::check(Auth::user())) {
                Auth::logout(Auth::user());
                return response()->json(["success" => true,
                                         "login" => false
                                        ]);
            }
            else {
                return response()->json(["success" => false,
                                          "message" => 'this_user_is_already_logout'
                                        ]);
            }
        }
        else {
            return response()->json(["success" => false,
                                     "message" => 'this_username_does_not_exist_in_database'
                                     ]);
        }
    }
    
  
}
