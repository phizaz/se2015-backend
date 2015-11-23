<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;
use App\drugRecord;

class DoctorController extends Controller
{
    
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

    public function drugRecordUpdate (Request $request,$drugId){

        if (!HospitalEmployee::isDoctor()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $name = $request->input('name');
        $quantity = $request->input('quantity');
        $remark = $request->input('remark');

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

        if(sizeof($error) != 0){
            return response()->json([
                "success" => false,
                "message" => $error
            ]);
        }

        $drug = drugRecord::where('drug_id',$drugId)->first();
        $drug->name = $name;
        $drug->quantity = $quantity;
        $drug->remark = $remark;
        $drug->save();

        return response()->json([
            "success" => true,
            "meessage" => 'saved drug record'
            ]);

    }

    public function drugRecordDelete ($drugId){

        if (!HospitalEmployee::isDoctor()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $drug = drugRecord::where('drug_id',$drugId)->first();
        $drug->delete();

        return response()->json([
            "success" => true,
            "meessage" => 'deleted drug record'
            ]);

    }

}
