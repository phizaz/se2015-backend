<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;

class DoctorController extends Controller
{
    public function doctor (){
        $doctorFirstname = [];
        $doctorLastname = [];
        $doctorId = [];
        $doctorSpecialty = [];
        $getDoctor = [];
            
        $doctors = HospitalEmployee::where('type','Doctor')->get();

        // echo 'eiei<br>';

        foreach ($doctors as $doctor) {
            // echo 'ii';
            // $doctorFirstname[] = $doctor->firstname;
            // $doctorLastname[] = $doctor->lastname;
            // $doctorId[] = $doctor->emp_id;
            // $doctorSpecialty[] = $doctor->specialty;

            // echo 'docro<br>';//$doctor->firstname;

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
