<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Patient;
use App\HospitalEmployee;
use App\Appointment;

class StaffEditController extends Controller
{
    public function getPatient(Request $request){

        if (!HospitalEmployee::isStaff()){
            return response()->json([
                "success" => false
                ]);
        }
        $firstname = $request->firstname;
        $lastname = $request->lastname;
        $patients = Patient::where('firstname','LIKE',"%$firstname%")
                    ->orWhere('lastname','LIKE',"%$lastname%")
                    ->select('id','firstname','lastname','birthdate','address','gender','nationality','bloodtype','tel')
                    ->get();

        $b = []

        foreach ($patients as $patApp) {
            $a = $patApp->appointments();
            // $patApp[] = $a;

            $c = $patApp->toArray();
            $c['appointments'] = $a->toArray();

            $b[]=$c;
        }

        return response()->json([
            "success" => true,
            "data" => $b
            ]);



    }
}
