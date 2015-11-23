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

 
//----------------------Function in List from Google Drive-------------------------
    //Done
    public function getDoctorAppointment($doctor_id) {
        // if(!HospitalEmployee::isDoctor())
        //     return response()->json(["success" = false];
        $appointments = Appointment::where('emp_id',$doctor_id)->get();
        return response()->json($appointments);
    }  

    //Done
    public function getByDoctor($doctor_id) { 
        // if(!HospitalEmployee::isDoctor())
        //     return response()->json(["success" = false];
        return response()->json( DoctorTime::getByDoctor($doctor_id) );
    }

    //Done
    // public function editDoctorTime($doctor_time_id, Request $request) {
    //     // if(!HospitalEmployee::isDoctor())
    //     //     return response()->json(["success" = false];
    //     $startTime = new Datetime($request->input('startTime'));
    //     $endTime = new Datetime($request->input('endTime'));
    //     return response()->json([ DoctorTime::editDoctorTime($doctor_time_id,
    //                                                          $startTime,
    //                                                          $endTime) ]);
    // }

    //Input = {"delete":{1},"doctor_id":{1},"create":{{"start":2015-01-01 16:00:00,"end":2015-01-01 20:00:00}}}
    public function editDoctorTime(Request $request) {
        $string = $request->input("data");
        $data = json_decode($string);
        $result = [];
        foreach($data["delete"] as $delete_id) {
            DoctorTimeController::deleteDoctorTime($delete_id);
        }
        foreach($data["create"] as $create) {
            $doctor_id = $data["doctor_id"];
            $startTime = $create["startTime"];
            $endTime = $create["endTime"];
            DoctorTime::makeDoctorTime($create);
            $result[] = DoctorTime::editDoctorTime($doctor_time_id,
                                                             $startTime,
                                                             $endTime) ;
        }
        //เรียก fuction refresh เพื่อไล่ check ว่า appointmentไหนไม่อยู่ในเวลาที่แพทย์สะดวกบ้างให้ลบทิ้ง
        $result[] = DoctorTime::refreshDoctorTime($data["doctor_id"]) ;
        return response()->json($result); 
    }

    //Done
    public function makeDoctorTime(Request $request) {
        // if(!HospitalEmployee::isDoctor())
        //     return response()->json(["success" = false];
        $doctorTime_begin = new Datetime($request->input('startTime'));
        $doctorTime_end = new Datetime($request->input('endTime'));
        $doctor_id = $request->input('doctor_id');

        return response()->json([ DoctorTime::makeDoctorTime( $doctor_id, $doctorTime_begin,
                                                              $doctorTime_end ) ]);
    }

    public function deleteDoctorTime($doctor_time_id) {
        // if(!HospitalEmployee::isDoctor())
        //     return response()->json(["success" = false];
        $doctorTime = DoctorTime::where('doctorTime_id',$doctor_time_id)->first();
        $doctorTime->delete();
        return response()->json(["success" => true]);
    }   
}
