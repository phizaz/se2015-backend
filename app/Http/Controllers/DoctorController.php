<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;
use App\drugRecord;

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

    public function drugRecord(Request $request){

         if (!HospitalEmployee::isDoctor()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $name = $request->input('name');
        $quantity = $request->input('quantity');
        $remark = $request->input('remark');
        $patientId = $request->input('patient_id');

        $error = [];
        if(!$name){
            $error[] = 'name_not_found';
        }
        if(!$quantity){
            $error[] = 'quantity_not_found';
        }
        if(!$remark){
            $error[] = 'remark_not_found';
        }
        if(!$patientId){
            $error[] = 'patienr_id_not_found';
        }

        if(sizeof($error) != 0){
            return response()->json([
                "success" => false,
                "message" => $error
            ]);
        }

        $drug = new drugRecord();
        $drug->name = $name;
        $drug->quantity = $quantity;
        $drug->remark = $remark;
        $drug->patient_id = $patientId;
        $drug->save();

        return response()->json([
            "success" => true,
            "meessage" => 'saved drug record'
            ]);

    }
}
