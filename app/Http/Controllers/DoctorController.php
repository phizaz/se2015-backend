<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;

class DoctorController extends Controller
{
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
