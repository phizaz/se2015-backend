<?php

namespace App;


use Illuminate\Database\Eloquent\Model;
class Appointment extends Model
{
    protected $primaryKey = 'appointment_id';

	public static function sendWarning($emailPatient, $telPatient, $time) {

	}
    //done
	public static function makeAppointment($search_type, $search_string, 
                                           $emp_id, $patient_id, $datetime) {
        $error = [];
        if($datetime == null)
            $error[] = 'datetime_not_found';
        if($patient_id == null)
            $error[] = 'patient_id_not_found';
        if($emp_id == null)
            $error[] = 'emp_id_not_found';
        if($search_type == null)
            $error[] = 'search_type_not_found';
        if($search_string == null)
            $error[] = 'search_string_not_found';
        if(Appointment::where('time',$datetime)->where('emp_id',$emp_id)->first())
            $error[] = 'this_time_not_available';

        if(sizeof($error)==0) {
            $appointment = new Appointment();
            $appointment->time = $datetime;
            $appointment->emp_id = $emp_id;
            $appointment->patient_id = $patient_id;
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


    //Done
    public static function deleteAppointment($appointment_id) {
        //$appointment_id = $appointment->input('appointment_id');
        if($appointment_id == null)
            return ["success" => false,
                    "message" => 'appointment_id_not_found'
                    ];
        if(Appointment::where('appointment_id', $appointment_id)->first()) {
            Appointment::where('appointment_id', $appointment_id)->delete();
            return ["success" => true,
                    ];
        }
        else {
            return ["success" => false,
                    "message" => 'this_appointment_does_not_exist_in_database'
                    ];
        }
    }

    //Done
    //get Patient's Appointment
    public static function getAppointmentPatient($patient_id) {
        if($patient_id == null)
            return ["success" => false,
                    "message" => 'patient_not_found'
                   ];
        // if(Patient::where('personal_id',$personal_id)->first()  ==null)
        //     return ["success" => false,
        //             "message" => 'this_patient_does_not_exist_in_database'
        //            ];

    	$appointment = Appointment::where('patient_id',$patient_id)->get();
    	if(sizeof($appointment)>0)
    		return $appointment;
    	else 
    		return ["message" => 'no_appointment_for_this_patient']; 
    }

    //Done
    //get Doctor's Appointment
    public static function getAppointmentDoctor($doctor_id) {
    	// $doctor_id = $doctor->input('doctor_id');
    	if($doctor_id == null)
            return ["success" => false,
                    "message" => 'patient_not_found'
                   ];
        $appointment = Appointment::where('emp_id',$doctor_id)->get();
        if(sizeof($appointment)>0)
            return $appointment;
        else 
            return ["message" => 'no_appointment_for_this_doctor']; 
    }

    //Done
    public static function getAppointmentStaff() {
    	return ["success" => true,
                Appointment::all()
               ];
    }

    public static function getLastAppointment($patient_id) {
        return array(Appointment::where('patient_id',$patient_id)->first());
    }

}
