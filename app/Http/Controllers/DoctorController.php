<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;
use App\drugRecord;
// use App\Http\Controllers\DateTime;
use DateTime;
use App\SymptomReport;
// use App\Http\Controllers\timestamps;
use App\TimeEntry;
use App\Patient;

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

    public function symptomReportCreate(Request $request){

        if (!HospitalEmployee::isDoctor()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $report = $request->input('name');
        $patientId = $request->input('patient_id');

        $error = [];
        if(!$report){
            $error[] = 'report_not_found';
        }
        if(!$patientId){
            $error[] = 'patient_id_not_found';
        }

        if(sizeof($error) != 0){
            return response()->json([
                "success" => false,
                "message" => $error
            ]);
        }

        $symptom = new SymptomReport();
        $symptom->report= $report;
        $symptom->patient_id = $patientId;
        $symptom->date = new DateTime('now');
        $symptom->save();

        return response()->json([
            "success" => true,
            "meessage" => 'saved symptom report'
            ]);        

    }

    public function symptomReportUpdate (Request $request,$sympId){

        if (!HospitalEmployee::isDoctor()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $report = $request->input('report');

        $error = [];
        if(!$report){
            $error[] = 'report_not_found';
        }

        if(sizeof($error) != 0){
            return response()->json([
                "success" => false,
                "message" => $error
            ]);
        }

        $sypmtom = SymptomReport::orderBy('symptom_id','desc')
                                  ->where('symptom_id',$sympId)
                                  ->first();
        $sypmtom->report = $report;
        $sypmtom->save();

        return response()->json([
            "success" => true,
            "meessage" => 'saved sypmtom record'
            ]);

    }

    public function symptomReportDelete ($symptomId){

        if (!HospitalEmployee::isDoctor()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $symptom = SymptomReport::where('symptom_id',$symptomId)->first();
        $symptom->delete();

        return response()->json([
            "success" => true,
            "meessage" => 'deleted symptom record'
            ]);

    }

    public function drugAllergic(Request $request,$patientId){

        if (!HospitalEmployee::isDoctor()){
            return response()->json([
                "success" => false,
                "error" => 'notlogin or notvalid'
                ]);
        }

        $drugAllergic = $request->input('drugAllergic');

        $error = [];
        if(!$drugAllergic){
            $error[] = 'drugAllergic_not_found';
        }

        if(sizeof($error) != 0){
            return response()->json([
                "success" => false,
                "message" => $error
            ]);
        }

        $drAllergic = Patient::where('id',$patientId)->first();
        $drAllergic->drugAllergic = $drugAllergic;
        $drAllergic->save();

        return response()->json([
            "success" => true,
            "meessage" => 'saved drugAllergic record'
            ]);

    }

}
