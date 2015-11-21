<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Patient;
use App\HospitalEmployee;

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
                    ->select('firstname','lastname', 'id')
                    ->get();

        return response()->json([
            "success" => true,
            "data" => $patients->toArray()
            ]);
    }

    public function getUnconfirmedStaff(){

        if (!HospitalEmployee::isStaff()){
            return response()->json([
                "success" => false
                ]);
        }

        $employee = HospitalEmployee::where('valid',false)
                    ->select()
                    ->get();

    }

}
