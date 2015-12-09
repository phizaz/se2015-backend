<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

use Auth;

class HospitalEmployee extends Model
{
	protected $table = 'hospital_employees';

  protected $primaryKey = 'emp_id';

  // config the toArray return types
  protected $casts = [
    'valid' => 'boolean',
  ];

  public function user() {
    return $this->morphOne('App\User', 'userable');
  }

  public static function create(array $attributes = []) {
    $employee = new HospitalEmployee;
    $employee->firstname = $attributes['firstname'];
    $employee->lastname = $attributes['lastname'];
    $employee->tel = $attributes['tel'];
    $employee->email = $attributes['email'];
    $employee->role = $attributes['role'];

    if ($attributes['role'] == 'Doctor') {
      $employee->specialty = $attributes['specialty'];
    }

    $employee->valid = false;
    $employee->save();

    // this will also create the User for authentication
    $user = new User;
    // duplicate personal id to username
    $user->username = $attributes['username'];
    $user->password = Hash::make($attributes['password']);
    $user->userable_id = $employee->emp_id;
    $user->userable_type = 'App\HospitalEmployee';
    $user->save();

    return $employee;
  }

  public static function isDoctor (){
    if(Auth::check()){
        $doctor = Auth::user()->userable;
        if($doctor->role == 'Doctor' && $doctor->valid){
          return true;
        }
    }
    return false;
  }

  public static function isNurse (){
    if(Auth::check()){
        $nurse = Auth::user()->userable;
        if($nurse->role == 'Nurse' && $nurse->valid){
          return true;
        }
    }
    return false;
  }

  public static function isStaff (){
    if(Auth::check()){
        $staff = Auth::user()->userable;
        if($staff->role == 'Staff' && $staff->valid){
          return true;
        }

    }
    return false;
  }

  public static function isPharmacist (){
    if(Auth::check()){
        $pharmacist = Auth::user()->userable;
        if($pharmacist->role == 'Pharmacist' && $pharmacist->valid){
          return true;
        }
    }
    return false;
  }

  public static function isHospitalEmployee (){
    if(Auth::check()){
        $hospitalEmployee = Auth::user()->userable;
        if($hospitalEmployee->role && $hospitalEmployee->valid){
          return true;
        }
    }
    return false;
  }

}
