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
        		"success" => false
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
}
