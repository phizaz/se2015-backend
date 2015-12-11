<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\HospitalEmployee;
use App\Patient;
use App\PatientReport;

class NurseController extends Controller
{
    public function getPatient (Request $request){
        if(!HospitalEmployee::isNurse()){
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

        $report = [];
        foreach ($patients as $patient){

        	$patientReport = PatientReport::orderBy('report_id','desc')
        						->where('patient_id', $patient->id)
                                ->get();

			$each = $patient->toArray();

        	if (!$patientReport){
				$each['patientReports'] = [];
	        } else {
	        	$each['patientReports'] = $patientReport;
	        }

	        $report[] = $each;

        }

        return response()->json([
        	"success" => true,
        	"data" => $report
        	]);

    }

    public function patientReport(Request $request,$patientId){

    	if(!HospitalEmployee::isNurse()){
        	return response()->json([
        		"success" => false,
                "error" => 'notlogin or notvalid'
        		]);
        }

    	$height = $request->input('height');
    	$weight = $request->input('weight');
    	$pressure = $request->input('pressure');

    	$error = [];
    	if(!$height){
    		$error[] = 'height_not_found';
    	}
    	if(!$weight){
    		$error[] = 'weight_not_found';
    	}
    	if(!$pressure){
    		$error[] = 'pressure_not_found';
    	}

    	if(sizeof($error) != 0){
    		return response()->json([
    			"success" => false,
    			"message" => $error
    			]);
    	}

    	$patientReport = new PatientReport;
    	$patientReport->patient_id = $patientId;
    	$patientReport->height = $height;
    	$patientReport->weight = $weight;
    	$patientReport->pressure = $pressure;
    	$patientReport->save();

    	return response()->json([
    		"success" => true,
            "data" => $patientReport,
 			"meessage" => 'saved record patient'
    		]);


    }

}
