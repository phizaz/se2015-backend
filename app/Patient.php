<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Appointment;
use App\PatientReport;
use App\SymptomReport;
use App\DrugRecord;
use Auth;

use DateTime;


class Patient extends Model
{
    protected $table = 'patients';

    public function user() {
      return $this->morphOne('App\User', 'userable');
    }

    public function latestPatientReport() {
      return PatientReport::where('patient_id', $this->id)
              ->orderBy('patient_id', 'desc')
              ->first();
    }

    public function symptomReports() {
      return $this->hasMany('App\SymptomReport', 'patient_id');
    }

    public function drugRecords() {
      return $this->hasMany('App\DrugRecord', 'patient_id');
    }

    /**
     * Override the toArray function to append 'username' (which belongs to App\User) to it
     * @return [type] [description]
     */
    // public function toArray() {
    //   $original = Parent::toArray($this);
    //   $new = array_merge($original, [
    //     'username' => $this->user->username,
    //     ]);

    //   return $new;
    // }

    public function futureAppointments(){
      return Appointment::where('patient_id',$this->id)->where('time', '>=', new DateTime('today'))->get();

    }

    public function appointments() {
      $patients = $this->id;
      $patient = User::where('id',$patients)->first();
      return Appointment::where('patient_id', $patient->id)->get();
    }

    //------------------isPatient------------------
    public static function isPatient (){
      if(Auth::check()) {
          $patient = Auth::user()->userable;
          if($patient->role == null) {
            return true;
          }
      }
      return false;
    }

    public static function create(array $attributes = []) {
      $patient = new Patient;
      $patient->personal_id = $attributes['personal_id'];
      $patient->firstname = $attributes['firstname'];
      $patient->lastname = $attributes['lastname'];
      $patient->birthdate = $attributes['birthdate'];
      $patient->address = $attributes['address'];
      $patient->gender = $attributes['gender'];
      $patient->religion = $attributes['religion'];
      $patient->nationality = $attributes['nationality'];
      $patient->bloodtype = $attributes['bloodtype'];
      $patient->tel = $attributes['tel'];
      $patient->email = $attributes['email'];
      $patient->remark = $attributes['remark'];
      $patient->save();

      // this will also create the User for authentication
      $user = new User;
      // duplicate personal id to username
      $user->username = $patient->personal_id;
      $user->password = Hash::make($attributes['password']);
      $user->userable_id = $patient->id;
      $user->userable_type = 'App\Patient';
      $user->save();

      return $patient;
    }

}
