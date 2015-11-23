<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Appointment;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Auth;
use App\Patient;
use App\DoctorTime;
use App\HospitalEmployee;
use DateTime; 
use DateInterval;
class MakeAppointmentController extends Controller
{
    //----------------------Function in List from Google Drive-------------------------
    
    //Done
    //---------------------------getFreeSlotByDoctor----------------------------
    public function getFreeSlotByDoctor( $doctor_id ) {
        if(!Patient::isPatient() && !HospitalEmployee::isDoctor() && !HospitalEmployee::isStaff())
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        return response()->json(["success" => true, 
                                 "data" => DoctorTime::getFreeSlotByDoctor($doctor_id)
                                ]);
    }

    //Done
    //-------------------------getFreeSlotBySpecialty---------------------------
    public function getFreeSlotBySpecialty( $specialty ) {
        if(!Patient::isPatient() && !HospitalEmployee::isDoctor() && !HospitalEmployee::isStaff())
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        return response()->json(["success" => true, 
                                 "data" => DoctorTime::getFreeSlotBySpecialty($specialty)
                                ]);
    }

    //Done
    //-------------------------makeAppointment---------------------------------
    public function makeAppointment(Request $request) {
        if(!Patient::isPatient() && !HospitalEmployee::isStaff())
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        $datetime =  $request->input('datetime');
        $emp_id = $request->input('doctor_id');

        $patient_id = Auth::user()->userable->id;
        
        return response()->json( ["success" => true, 
                                  "data" => Appointment::makeAppointment($emp_id, $patient_id, $datetime) 
                                 ]);
    }

    // Mai Tomg Tum Leaw
    public function bookAppointment(Request $request) {
        
    }
    
    //Done
    public function deleteAppointment($appointment_id) {
        if(!Patient::isPatient() && !HospitalEmployee::isStaff() && !HospitalEmployee::isDoctor())
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        return response()->json(Appointment::deleteAppointment($appointment_id));
    }

    //Done
    public function getAppointmentPatient(Request $request) {
        if(!Patient::isPatient() && !HospitalEmployee::isStaff())
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        $patient_id = $request->input('Patient_id');
        return response()->json(["success" => true, 
                                  "data" => Appointment::getAppointmentPatient($patient_id)
                                ]);
    }

    //Done
    //get Doctor's Appointment
    public function getAppointmentDoctor(Request $request) {
        if(!Patient::isPatient() && !HospitalEmployee::isDoctor() && !HospitalEmployee::isStaff())
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        $emp_id = $request->input('emp_id');
        return response()->json(["success" => true, 
                                "data" => Appointment::getAppointmentDoctor($emp_id)
                                ]);
    }

    //Done
    public function getAppointmentStaff() {
        if(!HospitalEmployee::isStaff())
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        return response()->json(["success" => true, 
                                 "data" => Appointment::getAppointmentStaff()
                                ]);
    }

    public function getLastAppointment($patient_id) {
        if(!Patient::isPatient() && !HospitalEmployee::isDoctor() && !HospitalEmployee::isStaff())
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        return response()->json(["success" => true, 
                                 "data" => Appointment::getLastAppointment($patient_id)
                                ]);
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
