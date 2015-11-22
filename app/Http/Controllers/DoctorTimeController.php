<?php

namespace App\Http\Controllers;
use Datetime;
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


    public function getDoctorAppointment(Request $request) {
        $doctor_id = $request->input('doctor_id');
        $appointment = Appointment::where('emp_id',$doctor_id)->get();
        return response()->json([ $appointment ]);
    }

    public function getByDoctor(Request $request) { 
        $doctor_id = $request->input('doctor_id');
        //$doctor = new DoctorTime();
        return response()->json([ DoctorTime::getByDoctor($doctor_id) ]);
    }

    public function getBySpecialty(Request $request) {
        $specialty = $request->input('specialty');
        return response()->json([ DoctorTime::getBySpecialty($specialty) ]);
    }

    public function editDoctorTime(Request $request) {
        $doctorTime_begin = new Datetime($request->input('doctorTime_begin'));
        $doctorTime_end = new Datetime($request->input('doctorTime_end'));
        $doctorTime_id = $request->input('doctorTime_id');
        echo '2323';
        return response()->json([ DoctorTime::editDoctorTime($doctorTime_id,
                                                             $doctorTime_begin,
                                                             $doctorTime_end) ]);
    }
    //
    public function makeDoctorTime(Request $request) {
        $doctorTime_begin = new Datetime($request->input('doctorTime_begin'));
        $doctorTime_end = new Datetime($request->input('doctorTime_end'));
        $doctor_id = $request->input('emp_id');

        return response()->json([ DoctorTime::makeDoctorTime( $doctor_id, $doctorTime_begin,
                                                              $doctorTime_end ) ]);
    }

    public function getFreeSlotByDoctor( Request $request ) {
        $doctor_id = $request->input('emp_id');
        return response()->json(DoctorTime::getFreeSlotByDoctor($doctor_id));
    }
    
    public function getFreeSlotBySpecialty( Request $request ) {
        $specialty = $request->input('specialty');
        return response()->json(DoctorTime::getFreeSlotBySpecialty($specialty));
    }
    
}
