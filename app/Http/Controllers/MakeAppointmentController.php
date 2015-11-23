<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use DateTime; 
use DateInterval;
class MakeAppointmentController extends Controller
{
    //test timestamp comparison
    // public function test(Request $request) {
        
    //     $time1 = new DateTime($request->input('time1'));
    //     $time2 = new DateTime($request->input('time2'));
    //     $time3 = new DateTime('2015-02-01 12:00:00');
    //     $time4 = new DateTime('2015-02-01 13:00:00');
        
    //     $time3->add(new DateInterval('PT0H15M0S'));
    //     echo $time3->format("h:i:s").'<br>';
    //     $time4->sub(new DateInterval('PT0H15M0S'));
    //     echo $time4->format("h:i:s").'<br>';
    //     echo $time4->format("s");

    //     // $interval = $time3->date_diff($time4);
    //     // echo $interval->format('s');
    //     if($time3 < $time4)
    //         echo '<br>yes yes yes';
    //     else 
    //         echo '<br>no no no';
    // }

    //Done
    // public function makeAppointment(Request $request) {
    //     $datetime =  $request->input('datetime');
    //     $emp_id = $request->input('doctor_id');

    //     $patient_id = Auth::user()->userable->id;
    //     // $patient_id = $request->input('patient_id');
    //     $filterType = $request->input('search_type');
    //     $filterString = $request->input('search_string');

    //     return response()->json( Appointment::makeAppointment($filterType, $filterString, 
    //                                        $emp_id, $patient_id, $datetime) );
    // }

    public function makeAppointment(Request $request) {
        $datetime =  $request->input('datetime');
        $emp_id = $request->input('doctor_id');

        $patient_id = Auth::user()->userable->id;
        
        return response()->json( Appointment::makeAppointment($emp_id, $patient_id, $datetime) );
    }


    public function bookAppointment(Request $request) {
        
    }
    
    //Done
    public function deleteAppointment(Request $request) {
        $appointment_id = $request->input('appointment_id');
        return response()->json(Appointment::deleteAppointment($appointment_id))    ;
    } 
    //Done
    public static function getAppointmentPatient(Request $request) {
        $patient_id = $request->input('personal_id');
        return response()->json(Appointment::getAppointmentPatient($patient_id));
    }
    //Done
    //get Doctor's Appointment
    public static function getAppointmentDoctor(Request $request) {
        $emp_id = $request->input('emp_id');
        return response()->json(Appointment::getAppointmentDoctor($emp_id));
    }
    //Done
    public static function getAppointmentStaff() {
        return response()->json(Appointment::getAppointmentStaff());
    }

    public static function getLastAppointment($doctor) {

    }
}
