<?php

namespace App\Http\Controllers;
//use Input;
use Auth;                    //for authentication
//Illuminate\Routing\Controller;
//use Illuminate\Auth;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Patient;
use App\User;
use App\HospitalEmployee;
use Illuminate\Support\Facades\Hash;
use App\DoctorTime;  //ลองๆ

use App\Http\Controllers\Controller;
  use Illuminate\Http\Response;
class UserController extends Controller {

//===============================Login==========================================
    public function islogin(Request $request) {

        if(Auth::check()) {
            // if(Auth::user()->userable->role == 'Doctor')
            //     $appointments = Appointment::getAppointmentDoctor(Auth::user()->userable->emp_id);
            // else if(Auth::user()->userable->role == null) {
            //     $appointments = Appointment::getAppointmentPatient(Auth::user()->userable->patient_id);
            $appointments = User::getUserAppointment(Auth::user());
            return response()->json(["login" => true,
                                     "data" => array_merge(Auth::user()->userable->toArray(), [
                                            "appointments" => $appointments
                                        ])
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

        $user = User::where('username', $username)->first();

        if (!$user || !Hash::check($password, $user->password)) {
            return response()->json([
                'success' => false,
                'message' => ['username_or_password_wrong']]);
        }

        $entity = $user->userable;

        if ($entity->role && !$entity->valid) {
            return response()->json([
                'success' => false,
                'message' => ['not_confirmed']]);
        }

        Auth::login($user);

        $result = Auth::user()->userable->toArray();
        $appointments = User::getUserAppointment(Auth::user());
        return response()->json([
            'success' => true,
            'data' => array_merge($result, [
                'appointments' => $appointments
            ])
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
