<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\DoctorTime;
use DateTime; 
use DateInterval;
class MakeAppointmentController extends Controller
{
    //----------------------Function in List from Google Drive-------------------------
    
    //Done
    //---------------------------getFreeSlotByDoctor----------------------------
    public function getFreeSlotByDoctor( $doctor_id ) {
        return response()->json(DoctorTime::getFreeSlotByDoctor($doctor_id));
    }

    //Done
    //-------------------------getFreeSlotBySpecialty---------------------------
    public function getFreeSlotBySpecialty( $specialty ) {
        return response()->json(DoctorTime::getFreeSlotBySpecialty($specialty));
    }

    //Done
    //-------------------------makeAppointment---------------------------------
    public function makeAppointment(Request $request) {
        $datetime =  $request->input('datetime');
        $emp_id = $request->input('doctor_id');

        $patient_id = Auth::user()->userable->id;
        
        return response()->json( Appointment::makeAppointment($emp_id, $patient_id, $datetime) );
    }

    // Mai Tomg Tum Leaw
    public function bookAppointment(Request $request) {
        
    }
    
    //Done
    public function deleteAppointment($appointment_id) {
        return response()->json(Appointment::deleteAppointment($appointment_id))    ;
    }

    //Done
    public function getAppointmentPatient(Request $request) {
        $patient_id = $request->input('personal_id');
        return response()->json(Appointment::getAppointmentPatient($patient_id));
    }

    //Done
    //get Doctor's Appointment
    public function getAppointmentDoctor(Request $request) {
        $emp_id = $request->input('emp_id');
        return response()->json(Appointment::getAppointmentDoctor($emp_id));
    }

    //Done
    public function getAppointmentStaff() {
        return response()->json(Appointment::getAppointmentStaff());
    }

    public function getLastAppointment($patient_id) {
        return Appointment::getLastAppointment($patient_id);
    }

    //------------------------getAllDoctor-------------------------
    public function doctor (){
        
        $getDoctor = [];
            
        $doctors = HospitalEmployee::where('role','Doctor')->where('valid',true)->get();


        foreach ($doctors as $doctor) {
           
            $getDoctor[] = ['firstname' => $doctor->firstname,
                            'lastname' => $doctor->lastname, 
                            'id' => $doctor->emp_id, 
                            'specialty' => $doctor->specialty];
        }

        return response()->json([
                "success" => true,
                "data" => $getDoctor

            ]);

    }
}
