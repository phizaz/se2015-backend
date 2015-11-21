<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Patient;

class StaffEditController extends Controller
{
    public function getPatient($firstname, $lastname){

        $patients = Patient::where('firstname','LIKE',"%$firstname%")
                    ->orWhere('lastname','LIKE',"%$lastname%")
                    ->get();



    }
}
ห