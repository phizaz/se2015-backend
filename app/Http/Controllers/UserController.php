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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     public function addDoctorTime(Request $request) { //ลองๆ
        $doctorTime = new DoctorTime();
        $doctorTime->doctor_id = $request->input('doctor_id');
        $doctorTime->doctorTime_begin = $request->input('doctorTime_begin');
        $doctorTime->doctorTime_end = $request->input('doctorTime_end');
        $doctorTime->save();
    }
    
//===============================Login==========================================
 
    public function islogin(Request $request) {
        $users = null;
        $personal_id = $request->input('personal_id');
        $username = $request->input('username');
        if ($personal_id) {
            $users = Patient::where('personal_id',$request->input('personal_id'))->first();     
        } else if($username) {
            $users = HospitalEmployee::where('username',$request->input('username'))->first();
        }
        else {
            return response()->json(["message" => 'this input does not include personal_id or username']);           
        }
        
        if($users) {
            if(Auth::check($users))
                return response()->json(["login" => true,
                                         "data" => Auth::user()->toArray()
                                        ]);
            else
                return response()->json(["login" => false
                                        ]);
        } else {
            return response()->json(["message" => 'this user does not exist in database']);           
        }
    }
//        $patient = Patient::where('personal_id',$request->input('personal_id'))->first();
//        $employee = HospitalEmployee::where('username',$request->input('username'))->first();
//        
//        if($patient) {
//            if(Auth::check($patient))
//                return response()->json(["login" => true,
//                                        "data" => Auth::user()->toArray()
//                                        ]);
//            else
//                return response()->json(["login" => false
//                                        ]);
//        }
//        else if($employee) {
//            if(Auth::check($employee)) // น่าจะยังcheckของemployee ไม่ได้เพราะไม่ได้ใส่ model => 'HospitalEmployee' ในไฟล์ auth.php 
//                return response()->json(["login" => true,
//                                        "data" => Auth::user()->toArray()
//                                        ]);
//            else
//                return response()->json(["login" => false
//                                        ]);
//        }
//    }

    public function login(Request $request) {
        $users = null;
        $personal_id = $request->input('personal_id');
        $password = $request->input('password');
        $username = $request->input('userbame');
        if($personal_id) {
            $users = Patient::where('personal_id',$personal_id)->first();
        } else if($username) {
            $users = HospitalEmployee::where('username',$username)-first();
        }
        else {
            return response()->json(["message" => 'this input does not include personal_id or username']);           
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
                                             "message" => 'wrong password'
                                            ]);
                }
        }
        else {                                            //กรณี user ไม่ได้อยู่ใน database
            return response()->json(["succes" => false,
                                     "message" => 'this user does not exist in database'
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
        if($request->input('personal_id')) {
            $users = Patient::where('personal_id', $request->input('personal_id'))->first();
        } else if($request->input('username')) {       
            $users = Patient::where('username', $request->input('username'))->first();        
        } else {
            return response()->json(["success" => false,
                                     "message" => 'this input does not include personal_id or username'
                                    ]);
        }
        if($users) {
//            if(Auth::check($patient)) {
//                Auth::logout($patient);
                if(Auth::check(Auth::user())) {
                    Auth::logout(Auth::user());
                return response()->json(["success" => true,
                                         "login" => false
                                        ]);
                }
                else {
                    return response()->json(["success" => false,
                                             "message" => 'this user is already logout'
                                            ]);
                }
        }
        else {
            return response()->json(["success" => false,
                                     "message" => 'this user does not exist in database'
                                     ]);
        }
    }
    
  
}
