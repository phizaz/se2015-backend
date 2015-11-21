<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
	public static function sendWarning($emailPatient, $telPatient, $time) {

	}
    //done
	public static function makeAppointment($search_type, $search_string, 
                                           $emp_id, $personal_id, $datetime) {
        $error = [];
        if($datetime == null)
            $error[] = 'datetime_not_found';
        if($personal_id == null)
            $error[] = 'personal_id_not_found';
        if($emp_id == null)
            $error[] = 'emp_id_not_found';
        if($search_type == null)
            $error[] = 'search_type_not_found';
        if($search_string == null)
            $error[] = 'search_string_not_found';
        if(Appointment::where('time',$datetime)->first())
            $error[] = 'this_time_not_available';

        if(sizeof($error)==0) {
            $appointment = new Appointment();
            $appointment->time = $datetime;
            $appointment->emp_id = $emp_id;
            $appointment->personal_id = $personal_id;
            $appointment->filterType = $search_type;
            $appointment->filterString = $search_string;

            $appointment->save();
            return ["success" => true, "data" => $appointment->toArray()];
        }
        else 
            return ["success" => false, "message" => $error];
	}

	public static function bookAppointment($doctor_id, $patinet_id, $datetime) {

	}

    //get Patient's Appointment
    public static function getAppointmentPatient($patient) {
    	$personal_id = $patient->personal_id;
    	$appointment = Appointment::where('personal_id',$personal_id)->get();
    	if($appointment)
    		return $appointment;
    	else 
    		return ["message" => 'no_appointment']; 
    }
    //get Doctor's Appointment
    public static function getAppointmentDoctor($doctor) {
    	$doctor_id = $doctor->input('doctor_id');
    	$appointment = Appointment::where('doctor_id',$doctor_id)->get();
    	if($appointment)
    		return $appointment;
    	else 
    		return ["message" => 'no_appointment'];
    }

    public static function getAppointmentStaff() {
    	return Appointment::all;
    }

    public static function deleteAppointment($appointment) {
    	$appointment_id = $appointment->appointment_id;
    	$appointmentDelete = Appointment::where('appointment_id',$appointment_id);
    	if($appointmentDelete)
    		$appointmentDelete->delete();
    	else
    		return ["message" => 'appointment_not_found'];
    }

    public static function getLastAppointment($patient_id) {

    }

}
