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

        $firstname = $request->firsrname;
        $lastname = $request->lastname;

        $patients = Patient::where('firstname','LIKE',"%$firstname%")
                    ->orWhere('lastname','LIKE',"%$lastname%")
                    ->select('id','firstname','lastname','birthdate','address','gender','nationality','bloodtype','tel')
                    ->get();

        $report = [];
        foreach ($patients as $temp){
        	$a = Patient::where('id',$temp->id)->first();
        	// echo $a;

        	$b = PatientReport::orderBy('report_id','desc')
        						->where('patient_id',$a->id)
        						->first();
        	
			$c = $temp->toArray();
        	if(!$b){
				$c['report'] = [];
	        }else{
	        	$c['report'] = $b->toArray();
	        }

	        $report[] = $c;

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
    	if($height == null){
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

    	$patient = new patientReport();
    	$patient->patient_id = $patientId;
    	$patient->height = $height;
    	$patient->weight = $weight;
    	$patient->pressure = $pressure;
    	$patient->save();

    	return response()->json([
    		"success" => true,
 			"meessage" => 'saved record patient'
    		]);


    }

}
