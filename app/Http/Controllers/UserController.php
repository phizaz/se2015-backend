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
class UserController extends Controller {

//===============================Login==========================================
    public function islogin(Request $request) {

        if(Auth::check()) {
            return response()->json(["login" => true,
                                     "data" => Auth::user()->userable->toArray()
                                    ]);
        } else
            return response()->json(["login" => false
                                    ]);
    }

    public function loginForm() {
        return view('login_form');
    }

    public function login(Request $request) {
        $username = $request->input('username');
        $password = $request->input('password');

        if (!Auth::attempt([
            'username' => $username,
            'password' => $password,
            ])) {
            return response()->json([
                'success' => false,
                'message' => ['username_or_password_wrong']]);
        }

        $result = Auth::user()->userable->toArray();

        return response()->json([
            'success' => true,
            'data' => $result,
            ]);
    }

    public function logout(Request $request) {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'message' => ['not_logged_in'],
                ]);
        }

        Auth::logout();

        return response()->json([
            'success' => true
            ]);
    }

}
