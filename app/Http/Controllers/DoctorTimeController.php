<?php

namespace App\Http\Controllers;
use Datetime;
use Illuminate\Http\Request;
use App\DoctorTime;
use App\Appointment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;

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
        if(!HospitalEmployee::isDoctor())
            return response()->json([
                "success" => false,
                "messages" => ['notlogin or notvalid']
                ]);

        $appointments = Appointment::where('emp_id',$doctor_id)->get();

        $appointments_array = [];

        foreach($appointments as $appointment) {
            $tmp = $appointment->toArray();
            $tmp['patient'] = $appointment->patient->toArray();
            $appointments_array[] = $tmp;
        }

        return response()->json([
            'success' => true,
            'data' => $appointments_array,
        ]);
    }

    //Done
    public function getByDoctor($doctor_id) {
        if(!HospitalEmployee::isDoctor())
            return response()->json([
                "success" => false,
                "messages" => ['notlogin or notvalid']
                ]);
        // if(!HospitalEmployee::isDoctor())
        //     return response()->json(["success" = false];
        return response()->json( DoctorTime::getByDoctor($doctor_id) );
    }


    //Input = {"delete":[23],"doctor_id":1,"create":[{"start":"2015-01-01 8:00:00","end":"2015-01-01 12:00:00"},{"start":"2015-01-01 14:00:00","end":"2015-01-01 16:00:00"}]}
    public function editDoctorTime(Request $request) {
        if(!HospitalEmployee::isDoctor())
            return response()->json([
                "success" => false,
                "messages" => ['notlogin or notvalid']
                ]);

        $string = $request->input("data");
        //$string = '{"delete":[37,38,39,40],"doctor_id":1,"create":[{"start":"2015-01-01 8:00:00","end":"2015-01-01 12:00:00"},{"start":"2015-01-01 14:00:00","end":"2015-01-01 16:00:00"}]}';
        $data = json_decode($string);
        $doctor_id = $data->doctor_id;


        foreach($data->delete as $delete_id) {
            //echo $delete_id;
            DoctorTimeController::deleteDoctorTime($delete_id);
        }
        foreach($data->create as $create) {
            $startTime = new DateTime($create->start);
            $endTime = new DateTime($create->end);
            // echo $startTime->format("y-m-d");
            // if($startTime->format("y-m-d") == $endTime->format("y-m-d"))
            //     return 'ddfdfd';
            //echo $create->start;
            DoctorTime::makeDoctorTime($doctor_id, $startTime, $endTime);
            //$result[] = DoctorTime::editDoctorTime($doctor_time_id,
            //                                                 $startTime,
            //                                                 $endTime) ;
        }
        //เรียก fuction refresh เพื่อไล่ check ว่า appointmentไหนไม่อยู่ในเวลาที่แพทย์สะดวกบ้างให้ลบทิ้ง
        //echo 'sdsd';
        $result = DoctorTime::refreshDoctorTime($doctor_id) ;

        return response()->json($result);
    }

    //Done
    public function makeDoctorTime(Request $request) {
        // if(!HospitalEmployee::isDoctor())
        //     return response()->json(["success" = false];
        if(!HospitalEmployee::isDoctor())
            return response()->json([
                "success" => false,
                "messages" => ['notlogin or notvalid']
                ]);

        $doctorTime_begin = new Datetime($request->input('startTime'));
        $doctorTime_end = new Datetime($request->input('endTime'));
        $doctor_id = $request->input('doctor_id');

        return response()->json([ DoctorTime::makeDoctorTime( $doctor_id, $doctorTime_begin,
                                                              $doctorTime_end ) ]);
    }

    public function deleteDoctorTime($doctor_time_id) {
        if(!HospitalEmployee::isDoctor())
            return response()->json([
                "success" => false,
                "messages" => ['notlogin or notvalid']
                ]);

        // if(!HospitalEmployee::isDoctor())
        //     return response()->json(["success" = false];
        $doctorTime = DoctorTime::where('doctorTime_id',$doctor_time_id)->first();
        if($doctorTime)
            $doctorTime->delete();
        return response()->json(["success" => true]);
    }
}
