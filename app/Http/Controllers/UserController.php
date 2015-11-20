<?php

namespace App\Http\Controllers;
//use Input;
use Auth;                    //for authentication
//Illuminate\Routing\Controller; 
//use Illuminate\Auth;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Patient;
use App\HospitalEmployee;
use Illuminate\Support\Facades\Hash;

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
        
        // if($personal_id) {
        //     $users = Patient::where('personal_id',$personal_id)->first();
        // } else if($username) {
        //     $users = HospitalEmployee::where('username',$username)-first();
        // }
        // else {
        //     return response()->json(["message" => 'this input does not include personal_id or username']);           
        // }
        $users = Patient::where('personal_id',$username)->first();
        if($users==null) {
//        } else {
            $users = HospitalEmployee::where('username',$username)->first();
        }
       

        if($users) {
            if(Hash::check($password,$users->password)) {   //กรณี Login สำเร็จ
                    Auth::login($users);
                    return response()->json(["success" => true,
                                             "login" => true,
                                             "data" => Auth::user()->toArray()
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
        
//        $personal_id = $request->input('personal_id');
//        $password = $request->input('password');
////  Login for Patient        
//        $patient = Patient::where('personal_id', $personal_id)->first();
//        if($personal_id){
//            if($patient) {
//                if(Hash::check($password,$patient->password)) {
//                    Auth::login($patient);
//                    return response()->json(["success" => true,
//                                             "login" => true,
//                                             "data" => Auth::user()->toArray()
//                                            ]);
//                }
//                else {
//                    return response()->json(["success" => false,
//                                           "message" => 'wrong password'
//                                            ]);
//                }
//            }
//            else {
//                return response()->json(["succes" => false,
//                                         "message" => 'personal_id_does not exist in Database'
//                                        ]);
//            }   
//        }
////  Login for Employee
//        $username = $request->input('username');
//        if($username) {
//            $employee = HospitalEmployee::where('username',$username)->first();
//            if($employee) {
//                if(Hash::check($password,$employee->password)) {
//                    Auth::login($employee);
//                    return response()->json(["success" => true,
//                                             "login" => true,
//                                             "data" => Auth::user()->toArray()
//                                            ]);
//                }
//                else {
//                    return response()->json(["success" => false,
//                                             "message" => 'wrong password'
//                                            ]);
//                }
//            }
//            else {
//                return response()->json(["succes" => false,
//                                         "message" => 'username not exist in Database'
//                                        ]);
//            }
//            
//            
//        }
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
        // if($request->input('personal_id')) {
        //     $users = Patient::where('personal_id', $request->input('personal_id'))->first();
        // } else if($request->input('username')) {       
        //     $users = Patient::where('username', $request->input('username'))->first();        
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
        
//        $personal_id = $request->input('personal_id');
//        $password = $request->input('password');
////  Login for Patient        
//        $patient = Patient::where('personal_id', $personal_id)->first();
//        if($personal_id){
//            if($patient) {
//                if(Hash::check($password,$patient->password)) {
//                    Auth::login($patient);
//                    return response()->json(["success" => true,
//                                             "login" => true,
//                                             "data" => Auth::user()->toArray()
//                                            ]);
//                }
//                else {
//                    return response()->json(["success" => false,
//                                           "message" => 'wrong password'
//                                            ]);
//                }
//            }
//            else {
//                return response()->json(["succes" => false,
//                                         "message" => 'personal_id_does not exist in Database'
//                                        ]);
//            }   
//        }
////  Login for Employee
//        $username = $request->input('username');
//        if($username) {
//            $employee = HospitalEmployee::where('username',$username)->first();
//            if($employee) {
//                if(Hash::check($password,$employee->password)) {
//                    Auth::login($employee);
//                    return response()->json(["success" => true,
//                                             "login" => true,
//                                             "data" => Auth::user()->toArray()
//                                            ]);
//                }
//                else {
//                    return response()->json(["success" => false,
//                                             "message" => 'wrong password'
//                                            ]);
//                }
//            }
//            else {
//                return response()->json(["succes" => false,
//                                         "message" => 'username not exist in Database'
//                                        ]);
//            }
//            
//            
//        }
    }
    
  
}
