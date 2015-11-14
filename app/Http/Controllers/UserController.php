<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Patient;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return 'login() is called';
    }

    public function register(Request $request) {

      $firstname = $request->input('firstname');

      $patient = new Patient;
      $patient->firstname = $firstname;
      $patient->save();

      return response()->json($patient-toArray());

    }
}
