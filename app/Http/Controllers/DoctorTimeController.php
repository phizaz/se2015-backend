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
    public function getByDoctor(Request $request) { 
        $doctor_id = $request->input('doctor_id');
        //$doctor = new DoctorTime();
        return response()->json(DoctorTime::getByDoctor($doctor_id));
        
    }
    
    
}
