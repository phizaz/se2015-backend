<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Appointment;


class Patient extends Model
{

    protected $table = 'patients';


    public function user() {
      return $this->morphOne('App\User', 'userable');
    }

    /**
     * Override the toArray function to append 'username' (which belongs to App\User) to it
     * @return [type] [description]
     */
    public function toArray() {
      $original = Parent::toArray($this);
      $new = array_merge($original, [
        'username' => $this->user->username,
        ]);

      return $new;
    }

    public function futureAppointments(){

      return Appointment::where('time', '>=', new DateTime('today'))

    }

    public function appointments() {
      $patients = $this->id;
      $patient = User::where('id',$patients)->first();
      return Appointment::where('patient_id', $patient->id)->get();
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
