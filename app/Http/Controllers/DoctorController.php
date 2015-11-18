<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;

class DoctorController extends Controller
{
    public function doctor (){
        $doctorName = [];
        $doctorSurname = [];
        $doctorId = [];

        while(){
            if(HospitalEmployee::where('type','Doctor')->first()){
                $doctor
            }
        }
    }
}
