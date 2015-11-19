<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\DoctorTime;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DoctorTimeController extends Controller
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

    public function getByDoctor(Request $request) { 
        $doctor_id = $request->input('doctor_id');
        //$doctor = new DoctorTime();
        return response()->json(DoctorTime::getByDoctor($doctor_id));
        
    }
    
    
}
