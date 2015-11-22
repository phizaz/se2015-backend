<?php

namespace App\Http\Controllers;
use Datetime;
use Illuminate\Http\Request;
use App\DoctorTime;
use App\Appointment;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DoctorTimeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */


    
    public function getBySpecialty(Request $request) {
        $specialty = $request->input('specialty');
        return response()->json([ DoctorTime::getBySpecialty($specialty) ]);
    }

    public function getFreeSlotByDoctor( Request $request ) {
        $doctor_id = $request->input('emp_id');
        return response()->json(DoctorTime::getFreeSlotByDoctor($doctor_id));
    }
    
    public function getFreeSlotBySpecialty( Request $request ) {
        $specialty = $request->input('specialty');
        return response()->json(DoctorTime::getFreeSlotBySpecialty($specialty));
    }
 
//----------------------Function in List from Google Drive-------------------------
    //Done
    public function getDoctorAppointment($doctor_id) {
        $appointments = Appointment::where('emp_id',$doctor_id)->get();
        return response()->json($appointments);
    }  

    //Done
    public function getByDoctor($doctor_id) { 
        return response()->json( DoctorTime::getByDoctor($doctor_id) );
    }

    //Done
    public function editDoctorTime($doctor_time_id, Request $request) {
        $startTime = new Datetime($request->input('startTime'));
        $endTime = new Datetime($request->input('endTime'));
        return response()->json([ DoctorTime::editDoctorTime($doctor_time_id,
                                                             $startTime,
                                                             $endTime) ]);
    }

    //Done
    public function makeDoctorTime(Request $request) {
        $doctorTime_begin = new Datetime($request->input('startTime'));
        $doctorTime_end = new Datetime($request->input('endTime'));
        $doctor_id = $request->input('doctor_id');

        return response()->json([ DoctorTime::makeDoctorTime( $doctor_id, $doctorTime_begin,
                                                              $doctorTime_end ) ]);
    }

    public function deleteDoctorTime($doctor_time_id) {
        $doctorTime = DoctorTime::where('doctorTime_id',$doctor_time_id)->first();
        $doctorTime->delete();
        return response()->json(["success" => true]);
    }   
}
