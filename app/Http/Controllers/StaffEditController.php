<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Patient;
use App\HospitalEmployee;
use App\Appointment;
use App\User;

class StaffEditController extends Controller
{
    public function getPatient(Request $request){

        if (!HospitalEmployee::isStaff()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }
        $firstname = $request->input('firstname');
        $lastname = $request->input('lastname');

        if ($firstname && !$lastname) {
            $lastname = 'unabletoguess';
        }

        if (!$firstname && $lastname) {
            $firstname = 'unabletoguess';
        }

        $patients = Patient::where('firstname','LIKE',"%$firstname%")
                    ->orWhere('lastname','LIKE',"%$lastname%")
                    ->get();

        $b = [];

        foreach ($patients as $patApp) {

            // $patApp[] = $a;

            $c = $patApp->toArray();

            $appointments = $patApp->futureAppointments();
            $appointments_array = [];
            foreach ($appointments as $appointment) {
                $each = $appointment->toArray();
                $each['doctor'] = $appointment->doctor->toArray();
                $appointments_array[] = $each;
            }

            $c['appointments'] = $appointments_array;
            // echo 'kk';
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
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $employee = HospitalEmployee::where('valid', 0)
                    ->get();

        return response()->json([
            "success" => true,
            "data" => $employee->toArray()
            ]);

    }

    public function approveStaff($empId){

        if (!HospitalEmployee::isStaff()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
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

    public function discardStaff($empId){
        if (!HospitalEmployee::isStaff()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $emp = HospitalEmployee::where('emp_id',$empId)->first();
        $usr = User::find($empId);
        if($emp->valid){
            // echo 'valid=false';
            return response()->json([
                "success" => false,
                "error" => 'valid = true'
                ]);
        }


        // DB::table('HospitalEmployee')->where('emp_id',$empId)->delete();

        $emp->delete();
        $usr->delete();

        return response()->json([
                "success" => true
            ]);
    }

}
