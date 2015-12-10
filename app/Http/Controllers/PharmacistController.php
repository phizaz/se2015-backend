<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;
use App\Patient;
use App\PatientReport;
use App\DrugRecord;

class PharmacistController extends Controller
{
    public function getPatient (Request $request){
        if(!HospitalEmployee::isPharmacist()){
          return response()->json([
            "success" => false,
                "error" => 'notlogin or notvalid'
            ]);
        }

        $patients = Patient::where('status', 1)->get();
        $result = [];

        foreach($patients as $patient) {
          $each = $patient->toArray();
          $each['drugRecords'] =
            DrugRecord::where('patient_id', $patient->id)
              ->where('check', 0)
              ->where('created_at', '>=', new \DateTime('today'))
              ->get();

          $result[] = $each;
        }

        return response()->json([
          'success' => true,
          'data' => $result
        ]);

    }

    public function finish(Request $request, $patientId) {
      if(!HospitalEmployee::isPharmacist()){
        return response()->json([
          "success" => false,
              "error" => 'notlogin or notvalid'
          ]);
      }

      $patient = Patient::find($patientId);
      if (!$patient) {
        return response()->json([
          'success' => false,
          'message' => 'patient not found',
        ]);
      }

      $drugs = DrugRecord::where('patient_id', $patient->id)
              ->where('check', 0)
              ->where('created_at', '>=', new \DateTime('today'))
              ->get();

      foreach($drugs as $drug) {
        $drug->check = 1;
        $drug->save();
      }

      $patient->status = 0;
      $patient->save();

      return response()->json([
        'success' => true,
        'data' => $patient->drugRecords,
      ]);

    }

}
