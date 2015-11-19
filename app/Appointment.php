<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
	public static function sendWarning($emailPatient, $telPatient, $time) {

	}

	public stativ function makeAppointment($search_type, $search_string, $doctor_id, $patient_id,$datetime) {

	}

	public static function bookAppointment($doctor_id, $patinet_id, $datetime) {

	}

    //get Patient's Appointment
    public static function getAppointmentPatient($patient) {
    	$personal_id = $patient->'personal_id';
    	$appointment = Appointment::where('personal_id',$personal_id)->get();
    	if($appointment)
    		return $appointment;
    	else 
    		return "message" => 'no_appointment'; 
    }
    //get Doctor's Appointment
    public static function getAppointmentDoctor($doctor) {
    	$doctor_id = $doctor->'doctor_id';
    	$appointment = Appointment::where('doctor_id',$doctor_id)->get();
    	if($appointment)
    		return $appointment;
    	else 
    		return "message" => 'no_appointment';
    }

    public static function getAppointmentStaff() {
    	return Appointment->get();
    }

    public static function deleteAppointment($appointment) {
    	$appointment_id = $appointment->'appointment_id';
    	$appointmentDelete = Appointment::where('appointment_id',$appointment_id);
    	if($appointmentDelete)
    		$appointmentDelete->delete();
    	else
    		return "message" => 'appointment_not_found';
    }

    public static function getLastAppointment($patient_id) {

    }

}
