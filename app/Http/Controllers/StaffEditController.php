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

        $b = [];

        foreach ($patients as $patApp) {
            $a = $patApp->futureAppointments();
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

    public function getUnconfirmedStaff(){

        if (!HospitalEmployee::isStaff()){
            return response()->json([
                "success" => false
                ]);
        }

        $employee = HospitalEmployee::where('valid',false)
                    ->select('emp_id','firstname','lastname','tel','email','role','specialty')
                    ->get();

        return response()->json([
            "success" => true,
            "data" => $employee
            ]);

    }

    public function approveStaff($empId){

        if (!HospitalEmployee::isStaff()){
            return response()->json([
                "success" => false
                ]);
        }

        // DB::table('HospitalEmployee')->where('emp_id',$empId)->update(['valid' => true]);
        $emp = HospitalEmployee::find($empId);
        $emp->valid = true;
        $emp->save();

        return response()->json([
                "success" => true
                ]);
        
    }

}
